OLA on Windows
==============

TODO: This doesn't compile

OLA is partially available on Windows using MSYS2. Please note that not all plugins are functional on Windows - only the
following are available:

- ArtNet
- Dummy
- ESP Net
- FTDI
- KiNet
- OSC
- Pathport
- SandNet
- Strand Shownet
- USB DMX

For other uses, consider using a Linux system, such as a [Raspberry Pi](ola_on_raspberry_pi).

These instructions are generally similar to [compiling from source](compiling_from_source) on a Linux system, but are
adapted slightly to the peculiarities of Windows. The troubleshooting advice there is applicable here as well.

Setup
=====

Start by downloading and installing [MSYS2](https://www.msys2.org/). *Be sure to follow their instructions all the way
through, including performing updates.*

MSYS2 installs a subsystem on your machine. This means it functions a bit differently than the standard Windows command
prompt. In particular:

- Copy is Ctrl + Insert.
- Paste is Shift + Insert.
- The directory separator is a forward slash (`/`).
- Directories appear differently than they do in Windows. The root is `/`; all directories descend from `/`.
  See [here](https://www.msys2.org/wiki/MSYS2-introduction/#file-system) for how MSYS2 maps your Windows drives
  and directories into this hierarchy. Your Windows "Documents" folder, unless you've moved it inside Windows, is likely
  at `/c/Users/<your username>/Documents`.

To install dependencies, launch "MSYS2 MSYS" from the Start Menu (it may have opened automatically after installation):

    pacman -S \
        base-devel \
        git \
        libutil-linux-devel \
        mingw-w64-x86_64-cppunit \
        mingw-w64-x86_64-libftdi \
        mingw-w64-x86_64-liblo \
        mingw-w64-x86_64-libmicrohttpd \
        mingw-w64-x86_64-libusb \
        mingw-w64-x86_64-protobuf \
        mingw-w64-x86_64-python \
        mingw-w64-x86_64-python-numpy \
        mingw-w64-x86_64-python-protobuf \
        mingw-w64-x86_64-toolchain

When asked which members to install, press enter to install all. This process will take quite some time.

If you're using USB devices, use [Zadig](https://zadig.akeo.ie/) to install the libusbK for each FTDI device.

Run the below command to tell the build system where to find the newly-installed packages:

     echo "export PKG_CONFIG_PATH=/usr/lib/pkgconfig:${PKG_CONFIG_PATH}" >> ~/.bashrc

Now close the MSYS2 window.

Build
=====

From the Start Menu, launch "MSYS2 MinGW 64-bit".

Navigate to the directory you wish to use to build OLA.
Run `git clone https://github.com/OpenLightingProject/ola.git && cd ola`.

If this is the first time compiling with this download, generate the build system:

    autoreconf -i

OLA uses autotools for building. Run `./configure --help` to see all options.

To install with all available Windows plugins, run:

    ./configure \
        --enable-python-libs \
        --disable-all-plugins \
        --enable-artnet \
        --enable-dummy \
        --enable-espnet \
        --enable-ftdidmx \
        --enable-kinet \
        --enable-osc \
        --enable-pathport \
        --enable-sandnet \
        --enable-shownet \
        --enable-usbdmx

To build OLA after configuring, run:

    make -j$(nproc)
    make check
    make install

TODO: Usage
