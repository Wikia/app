use Module::Build::JSAN;

my $builder = Module::Build::JSAN->subclass(
    class => 'Module::Build::JSAN::Wikiwyg',
    code  => wikiwyg_build_code(),
);

my $build = $builder->new(
    module_name    => 'Wikiwyg',
    license        => 'lgpl',
    dist_author    => 'Ingy döt Net <ingy@cpan.org>',
    abstract       => 'Wysiwyg Editing for Social Software',
    create_readme  => 1,
    keywords       => [qw[wikiwyg wysiwyg editor]],
    get_options    => {
                        'css-prefix' => { type => '=s' },
                        'js-prefix'  => { type => '=s' },
                        'img-prefix' => { type => '=s' },
                      },
);

$build->create_build_script;


sub wikiwyg_build_code { q[

sub ACTION_install {
    my $self = shift;

    $self->_copy_dist_files(
        to     => $self->args('css-prefix'),
        ext    => qr/\.css/,
        from   => 'css',
    ) if $self->args('css-prefix');
    
    $self->_copy_dist_files(
        to     => $self->args('img-prefix'),
        ext    => qr/\.gif/,
        from   => 'images',
    ) if $self->args('img-prefix');

    $self->_copy_dist_js_files(
        to     => $self->args('js-prefix'),
        ext    => qr/\.js/,
        from   => 'lib',
    ) if $self->args('js-prefix');
}

sub _copy_dist_js_files {
    my ($self, %args) = @_;

    my @files = $self->_find_dist_files(
        ext  => $args{ext},
        from => $args{from},
    );
    
    for my $file ( @files ) {
        my $to_file = lc $file;
        $to_file =~ s[^lib/][];
        $self->copy_if_modified(
            from    => $file,
            to      => "$args{to}/$to_file",
        ) for @files;
    }
}

sub _copy_dist_files {
    my ($self, %args) = @_;

    my @files = $self->_find_dist_files(
        ext  => $args{ext},
        from => $args{from},
    );
    
    $self->copy_if_modified(
        from    => $_,
        to_dir  => $args{to},
        flatten => 1,
    ) for @files;
}

sub _find_dist_files {
    my ($self, %args) = @_;

    require File::Find::Rule;
    my @files = File::Find::Rule->new->file
                                     ->name(qr/$args{ext}$/)
                                     ->in($args{from});
    return @files;
}

] }
