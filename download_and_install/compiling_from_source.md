Compiling From Source
=====================

OLA developers recommend using the latest [pre-built packages](download_and_install). Compile from source if a release
is not available for your system, you wish to try bleeding-edge features, or want to contribute to development.

**Before compiling and installing from source, be sure to remove any pre-packaged OLA installations, as they will likely
conflict.**

If you're testing development releases and find an issue, please report it on
the [issue tracker](https://github.com/OpenLightingProject/ola/issues).

OLA source code lives on [GitHub](https://github.com/OpenLightingProject/ola). Stable releases are available from
the [releases page](https://github.com/OpenLightingProject/ola/releases); this is what you want if compiling only
because OLA is not packaged on your system. For the latest code,
run `git clone https://github.com/OpenLightingProject/ola.git`.

OLA uses `MAJOR.MINOR.PATCH` branches. The latest development happens on the `master` branch. Features and fixes under
testing are in the minor branch (i.e. `0.x`). Release candidates are on the patch branch (i.e. `0.10.x`). Checkout your
preferred level of stability with `git checkout <branch>` or a final release with `git checkout tags/<release>`. If
you're a developer, always work against the `master` branch. See `README.developer` for more developer advice.

Dependencies
============

OLA depends on the following third-party libraries:

- [avahi](https://www.avahi.org) if you want to use network discovery.
- [microhttpd](https://www.gnu.org/software/libmicrohttpd/) (if you want the web UI).
- autoconf
- automake
- cppunit
- ncurses
- lex (or flex)
- libftdi
- liblo
- libtool
- libusb
- pkg-config
- [Protobuf](https://developers.google.com/protocol-buffers) (version 3.6 or later)
- uuid or ossp uuid
- yacc (or bison)
- zlib

The Python library also requires:

- Numpy
- Protobuf for Python

Debian/Ubuntu
-------------

Debian/Ubuntu users can install all dependencies with:

    sudo apt-get install \
        autoconf \
        automake \
        bison \
        flex \
        g++ \
        libavahi-client-dev \
        libcppunit-dev \
        libftdi-dev \
        liblo-dev \
        libmicrohttpd-dev \
        libncurses-dev \
        libprotobuf-dev \
        libprotoc-dev \
        libtool \
        libusb-1.0.0-dev \
        make \
        protobuf-compiler \
        pkg-config \
        uuid-dev \
        zlib1g-dev

CentOS/RHEL/Fedora
------------------

Distributions using RPM packages can install all dependencies with:

    sudo dnf install \
        autoconf \
        automake \
        avahi-devel \
        bison \
        cppunit-devel \
        flex \
        gcc-c++ \
        libftdi-devel \
        liblo-devel \
        libmicrohttpd-devel \
        libtool \
        libusbx-devel \
        make \
        ncurses-devel \
        protobuf-lite-devel \
        uuid-devel \
        zlib-devel

macOS
-----

Dependencies are available from [MacPorts](https://www.macports.org/):

    sudo port install \
        autoconf \
        automake \
        bison \
        cppunit \
        flex \
        libftdi1 \
        liblo \
        libmicrohttpd \
        libtool \
        libusb \
        libuuid \
        ncurses \
        pkgconfig \
        protobuf3-cpp \
        zlib

or [Homebrew](https://brew.sh/):

    brew install \
        autoconf \
        automake \
        bison \
        cppunit \
        flex \
        libftdi \
        liblo \
        libmicrohttpd \
        libtool \
        libusb \
        libuuid \
        ncurses \
        pkg-config \
        protobuf \
        zlib

Python dependencies
-------------------

If you wish to build the Python library, additional libraries are required:

### From apt (preferred on Debian/Ubuntu)

    sudo apt-get install \
        python3-numpy \
        python3-protobuf

### From dnf (preferred on CentOS/RHEL/Fedora)

    sudo dnf install \
        python3-numpy \
        python3-protobuf

### From MacPorts

    sudo port install \
        py-numpy \
        py-protobuf3

### From Homebrew

    brew install \
        numpy \
        protobuf

The `protobuf` package from Homebrew installs both the C++ and Python Protobuf components.

### From pip

    pip3 install --user \
        numpy \
        protobuf

Note that there are known problems with the client library on Ubuntu when using libraries from pip.

Build
=====

If this is the first time compiling with this download, generate the build system:

    autoreconf -i

OLA uses autotools for building. Run

     ./configure --help

to see all options. The most popular option is `--enable-python-libs` to build the Python client module. If you want to
use the RDM responder tests, add `--enable-rdm-tests`.

Once you’ve decided on the options, it’s time to build OLA.

    ./configure <your options>
    make -j$(nproc)
    make check
    sudo make install

Mac users should use `make -j$(sysctl -n hw.logicalcpu)` instead of `make -j$(nproc)`.

Finally, run `sudo ldconfig` to make new libraries available.

Device drivers
==============

Note that, for some devices, it is necessary to install drivers for OLA to work with them. For example, the
[Open DMX USB](http://opendmx.net/index.php/Open_DMX_USB "Open DMX USB") device needs an additional kernel module that
could be built using the instructions on
[LLA\_and\_Q\_Light\_Controller\_Ubuntu\_Tutorial](http://opendmx.net/index.php/LLA_and_Q_Light_Controller_Ubuntu_Tutorial)
. For other devices, refer to the corresponding device page on the wiki.

Known Issues
============

If you get an error like the following:

    /bin/sh ./libtool --tag=CC   --mode=compile gcc -DHAVE_CONFIG_H -I.   -I/opt/local/var/macports/software/protobuf-cpp/2.0.3_0/opt/local/include/  -g -O2 -c -o ltdl.lo ltdl.c
    ./libtool: line 464: CDPATH: command not found
    /Users/simonn/lighting/lla/libltdl/libtool: line 464: CDPATH: command not found
    /Users/simonn/lighting/lla/libltdl/libtool: line 1142: func_opt_split: command not found
    libtool: Version mismatch error.  This is libtool 2.2.6, but the
    libtool: definition of this LT_INIT comes from an older release.
    libtool: You should recreate aclocal.m4 with macros from libtool 2.2.6
    libtool: and run autoconf again.

Your system uses a different version of libtool. Run:

     libtoolize --ltdl -c -f

and then start from the autoreconf step again.

If you should get the following error try to fix it with one of
[two available solutions](https://groups.google.com/group/open-lighting/msg/72060f6327d30df6):

    Rpc.pb.cc: In copy constructor 'ola::rpc::RpcMessage::RpcMessage(const ola::rpc::RpcMessage&)': 
    Rpc.pb.cc:143: error: base class 'class google::protobuf::Message' should be explicitly initialized in the copy constructor

You should be able to prevent this
by [editing `./src/Makefile.am`](https://groups.google.com/group/open-lighting/msg/c6d86d03dd74ed5b), removing `-Werror`
and then start from the autoreconfig step again.

If you get

    In file included from ./common/rdm/PidStoreLoader.h:32:0,
                     from common/rdm/PidStore.cpp:24:
    ./common/rdm/Pids.pb.h:17:2: error: #error This file was generated by an older version of protoc which is
     #error This file was generated by an older version of protoc which is
      ^
    ./common/rdm/Pids.pb.h:18:2: error: #error incompatible with your Protocol Buffer headers. Please
     #error incompatible with your Protocol Buffer headers.  Please
      ^
    ./common/rdm/Pids.pb.h:19:2: error: #error regenerate this file with a newer version of protoc.
     #error regenerate this file with a newer version of protoc.

Then you should run

    make clean

to clean out the old protobuf files.

Optional
========

Doxygen Documentation
---------------------

There is also an option to build the doxygen documentation! To do so, you will need to install
[doxygen](http://www.doxygen.nl/manual/install.html) (available from package managers on all popular systems).

Once you have installed Doxygen you may need to run `./configure` in your ola directory, so that it can generate the
correct make file. To build the docs just use:

     make doxygen-doc

You’ll have to run a webserver to get the experience. A simple way to do this is to navigate to `open-lighting/html` and
run:

     python3 -m http.server 8000 --bind 127.0.0.1

This starts a web server at http://127.0.0.1:8000.
