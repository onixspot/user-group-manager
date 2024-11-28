#!/usr/bin/env bash

DATA_DIR='/ssl'
CRT_FILE="${HOSTNAME}.crt"
KEY_FILE="${HOSTNAME}.key"
PEM_FILE="${HOSTNAME}.pem"

init_ssl() {
  openssl req -x509 -out "$CRT_FILE" -keyout "$KEY_FILE" \
    -newkey rsa:2048 -nodes -sha256 \
    -subj "/CN=${HOSTNAME}" -extensions EXT -config <(
      cat <<EOF
[dn]
CN=${HOSTNAME}
[req]
distinguished_name = dn
[EXT]
subjectAltName=DNS:${HOSTNAME}
keyUsage=digitalSignature
extendedKeyUsage=serverAuth
EOF
    )
  cat "$CRT_FILE" "$KEY_FILE" >"$PEM_FILE"
  cp "$CRT_FILE" /usr/local/share/ca-certificates/
  update-ca-certificates
}

main() {
  test -e $DATA_DIR || mkdir -p $DATA_DIR
  cd $DATA_DIR || {
    echo -e "\e[32m[ERROR] $DATA_DIR: no such directory\e[0m"
    exit 1
  }

  case "$1" in
  init) init_ssl ;;
  --data-dir) echo $DATA_DIR ;;
  --pem) cat <"$PEM_FILE" ;;
  esac

  cd - || return
}

main "$@"
