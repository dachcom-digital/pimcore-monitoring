use lib './lib';
use strict;
use warnings;
no warnings;
use Getopt::Long;
use LWP::Simple;
use Data::Dumper;
use JSON;
use utf8;

# disable ssl-check, since we anyway know who we check
$ENV{PERL_LWP_SSL_VERIFY_HOSTNAME} = 0;

my $appserver;       # Protocol & Domain
my $reportlevel = 1; # reporting level; 0: show all; 1: show critical and warning; 2: show critical only
my $verbose;
my $help;
GetOptions("server=s" => \$appserver, "level=s" => \$reportlevel, "verbose|v"=>\$verbose, "h|help"=>\$help)
    or die("Please provide valid 'server' parameter (Example: perl pimcore-checker.pl --server=https://solution.dachcom.com/)\n");

if($help){
    print <<EOF
Pimcore-Checker script for dachcom-digital/pimcore-monitoring bundle 1.0, by DACHCOM.CH

    perl pimcore-checker.pl --server=<server> [--level, --verbose, --help]


Parameters:
    --server        Protocol and domain of installation to check (p.e. https://solution.dachcom.com/)
optional:
    --level         minimum errorlevel to return, default is 1 (0: show all; 1: show critical and warning; 2: show critical only)
    --verbose, -v   additionally output gathered package-informations as json
    --help, -h      print this help
EOF
    ;
    exit(0);
}

if ($reportlevel > 2 || $reportlevel < 0) {
    $reportlevel = 1;
}

if (!$appserver) {
    die("Please provide 'server' parameter (Example: perl pimcore-checker.pl --server=https://solution.dachcom.com/)\n");
}

# program definitions
my $ERROR_LEVELS = [ 'OK', 'WARNING', 'CRITICAL' ];
my $ERROR_MESSAGES = {
    'OK'       => 'OK',
    'WARNING'  => 'Attention',
    'CRITICAL' => 'SEVERE ISSUES FOUND'
};
my $SUBSTITUTED_OPERANDS = {
    '<'  => 'lt',
    '>'  => 'gt',
    '==' => 'eq',
    '!=' => 'ne'
};


# load config
my $config = decode_json(_slurp_file('config/versions.json'));

my $API_CODE = $config->{ApiCode} || 'XoXPCMDwTj2UygzejP2eV43qhUNgdckudmPGbgphNTZXMQ'; # this code is the same as you configure for the monitoring-bundle
my $URL_APPENDIX = "/monitoring/fetch";

(my $url = $appserver . $URL_APPENDIX) =~ s{(\w)//}{$1/}g;

my $browser = LWP::UserAgent->new;
my $response = $browser->post($url, [ 'apiCode' => $API_CODE ]);

die "Couldn't get data for $url" unless defined $response;

my $checks = {};
my $appServerData = JSON::decode_json($response->content);

# check core
if (my $configCore = $config->{core} and my $appServerDataCore = $appServerData->{core}) {
    my $appCoreVersion = $appServerDataCore->{version};
    my $res = _compare_versions($configCore, $appCoreVersion);
    $checks->{core} = $res;
    $checks->{byLevel}->{$res}->{core} = $appCoreVersion;
}

# check extensions
if (my $configCore = $config->{extensions} and my $appServerDataCore = $appServerData->{extensions}) {
    foreach my $appExtension (@{$appServerDataCore}) {
        my $appCoreVersion = $appExtension->{version};

        my $comparisonResult =
            _compare_versions($configCore->{GENERAL}, $appCoreVersion)
                || _compare_versions($configCore->{$appExtension->{identifier}}, $appCoreVersion)
                || @$ERROR_LEVELS[-1];
        $checks->{extensions}->{$appExtension->{identifier}} = $comparisonResult;
        $checks->{byLevel}->{$comparisonResult}->{extension}->{$appExtension->{identifier}} = $appCoreVersion;
    }
}

# add security_check infos
if (my $checkdata = $appServerData->{security_check}) {
    if (ref $checkdata eq "HASH") {
        foreach my $packagename (keys %{$checkdata}) {
            $checks->{byLevel}->{CRITICAL}->{PHP}->{$packagename} = 1;
        }
    }
    elsif (ref $checkdata eq "ARRAY") {
        foreach my $packagename (@{$checkdata}) {
            $checks->{byLevel}->{CRITICAL}->{PHP}->{$packagename} = 1;
        }
    }
}

_print_summary_and_bye($checks);

# helpers
sub _print_summary_and_bye {
    my $checks = shift();

    my $message;
    my $warnlevel;
    my $startlevel = 2;
    foreach my $level (reverse @$ERROR_LEVELS) {
        if ($startlevel >= $reportlevel) {
            if (exists $checks->{byLevel}->{$level}) {
                $warnlevel ||= $startlevel;
                $message .= uc $level . ": ";

                foreach my $type (sort keys %{$checks->{byLevel}->{$level}}) {
                    $message .= "$type: ";
                    if (ref $checks->{byLevel}->{$level}->{$type}) {
                        foreach my $name (sort keys %{$checks->{byLevel}->{$level}->{$type}}) {
                            $message .= $name . " ($checks->{byLevel}->{$level}->{$type}->{$name}); ";
                        }
                    }
                    else {
                        $message .= $checks->{byLevel}->{$level}->{$type} . "; ";
                    }
                }
            }
            $startlevel--;
        }
    }
    $message = $ERROR_MESSAGES->{@$ERROR_LEVELS[$warnlevel]} . " - " . $message . "\n";
    print $message ;
    if($verbose){
        print encode_json($checks->{byLevel});
    }

    exit($warnlevel);
}

sub _slurp_file {
    my ($filepath) = @_;

    if (-e $filepath) {
        open my $fh, '<', $filepath or die "Can't open file $!";
        my $content = do {
            local $/;
            <$fh>
        };
        close $fh;

        return $content;
    }
    return undef;
}

sub _analyse_version {
    my ($version) = @_;

    if ($version) {
        if ($version =~ s{^(\D)(\d)}{$2}) {
            return($1, $version);
        }
        else {
            return('==', $version);
        }
    }
    return('!=', undef);
}

# check $versionToCheck against a definition through $ERROR_LEVELS and return ERROR_LEVEL
# returns highest ERROR_LEVEL if nothing matches
sub _compare_versions {
    my ($config, $versionToCheck) = @_;
    my $result = undef;

    foreach my $acceptanceLevel (@$ERROR_LEVELS) {
        if ($config->{$acceptanceLevel}) {
            for my $configVersion (@{$config->{$acceptanceLevel}}) {
                if ($configVersion eq $versionToCheck) {
                    $result = $acceptanceLevel;
                }
                else {
                    my ($op, $v) = _analyse_version($configVersion);

                    if (!exists $SUBSTITUTED_OPERANDS->{$op}) {
                        die "operand $op not substituted. Please check configuration.";
                    }

                    my $evaluation = eval "\"$versionToCheck\" $SUBSTITUTED_OPERANDS->{$op} \"$v\"" ? 1 : 0;
                    if ($evaluation) {
                        $result = $acceptanceLevel;
                    }
                }
            }
        }
    }

    return $result || undef;
}
