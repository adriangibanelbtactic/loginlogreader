#
# Copyright (C) 2024 BTACTIC, S.C.C.L.
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation, version 2 of
# the License.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License.
# If not, see <http://www.gnu.org/licenses/>.
#

app_name=loginlogreader
package_name=$(app_name)

all: dist/$(package_name).tar.gz

clean:
	rm -rf build/*
	rm -f dist/$(package_name).tar.gz

dist/$(package_name).tar.gz:
	mkdir -p build
	mkdir -p dist
	rsync -r \
		appinfo \
		img \
		lib \
		templates \
		LICENSE \
		build/$(app_name)/
	cp LICENSE build/LICENSE
	cd "build/$(app_name)" && find . -type f -not -name "$(app_name).md5" -exec md5sum "{}" + > "$(app_name).md5"
	cd build/ && tar czf $(app_name).tar.gz $(app_name) --owner=0 --group=0
	mv build/$(app_name).tar.gz dist/
