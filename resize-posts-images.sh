#!/bin/bash

SRC_DIR="source/assets/img/posts"
mogrify -resize 896x315! "$SRC_DIR"/*.jpg

for img in "$SRC_DIR"/*.jpg; do
  if [[ -f "$img" ]]; then
    webp="${img%.jpg}.webp"
    cwebp -q 100 "$img" -o "$webp"
    rm $img
  fi
done