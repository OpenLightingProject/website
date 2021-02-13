Compiling From Source
=====================

OLA source code lives on [GitHub](https://github.com/OpenLightingProject/ola).
Stable releases are available from the [releases page](https://github.com/OpenLightingProject/ola/releases);
for bleeding-edge development releases, run `git clone https://github.com/OpenLightingProject/ola.git`.

Dependencies
============

You need a couple of libraries installed for everything to work correctly.

First you’ll need at least the following:

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

The Python library also requires

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

    pip3 install --user \
        numpy \
        protobuf

If the pip3 command does not exist, install python3-pip from your package manager and try again.

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

Mac users should run use `make -j$(sysctl -n hw.logicalcpu)` instead of `make -j$(nproc)`.

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

Once you have installed Doxygen you may need to run ./configure in your ola directory, so that it can generate the
correct make file. To build the docs just use:

     make doxygen-doc

You’ll have to run a webserver to get the experience. A simple way to do this is to navigate to open-lighting/html and
run:

     python -m SimpleHTTPServer

This opens a web server at your local IP address on port 8000. It can be accessed through 127.0.0.1:80000 on your local
machine as well.
