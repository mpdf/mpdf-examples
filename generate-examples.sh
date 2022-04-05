#!/bin/bash

trap "echo Exited!; exit;" SIGINT SIGTERM

if [ $# -eq 0 ]; then
    echo "usage ./generate-examples.sh <PHP version>[ <path to mPDF>]"
    exit 1
fi

export MPDF_ROOT=${2:-"$PWD"}

if [ ! -f "${MPDF_ROOT}/vendor/autoload.php" ]; then
    echo "Unable to find composer autoload in given mPDF path ${MPDF_ROOT}"
    exit 1
fi

files=(./example*_*.php)
echo "Total files in list: ${#files[*]}, mPDF path ${MPDF_ROOT}"
for var in "${files[@]}"
do
  var="$(sed s/^\\\.\\\///g <<<$var)"
  mkdir -p "examples${1}"
  /usr/bin/time -f "%e ${var}" php${1} "${var}" > "examples${1}/${var}.pdf"
done
exit
