Download and Install
====================

Pre-built binaries
------------------

OLA is available pre-built on many platforms:

### Debian/Ubuntu (including Raspberry Pi)

Raspberry Pi users may want to see the [Raspberry Pi Quick-Start Guide](ola_on_raspberry_pi)

Ubuntu users will need the `universe` repository enabled.

    sudo apt-get update
    sudo apt-get install ola

### OpenSUSE

Available from [multimedia:libs](https://build.opensuse.org/package/show/multimedia:libs/ola):

    sudo zypper addrepo https://download.opensuse.org/repositories/multimedia:/libs/<VERSION> multimedia_libs
    sudo zypper install ola

If this is the first time software is installed from multimedia:liba, you may need to accept their package signing key.

### Gentoo

Gentoo packages are in progress [here](https://github.com/gentoo/gentoo/pull/15017).

### macOS

Available from [MacPorts](https://ports.macports.org/port/ola/summary):

    sudo port install ola

or [Homebrew](https://formulae.brew.sh/formula/ola#default):

    brew install ola

Build from source
-----------------

To stay on the bleeding edge with new and exciting features, [compile from source](compiling_from_source)

Windows
-------

OLA hasn’t been ported to Windows yet. In the meantime you can run
[OLA on Windows with VMWare](https://www.openlighting.org/ola/tutorials/ola-on-windows-via-vmware/)

TODO: VMWare is quite out of fashion, explore using VirtualBox or maybe even Docker.
