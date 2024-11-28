#!/usr/bin/env bash

prepare_certificate() {
  bin/ssl.sh --pem >"/docker-entrypoint.d/$HOSTNAME.pem"
}

prepare_unit_config() {
  cat <config/unit.json |
    jq '.listeners["*:443"].tls.certificate |= "\(env.HOSTNAME).pem"' |
    cat >/docker-entrypoint.d/unit.json
}
harmonize() {
  prepare_certificate
  prepare_unit_config
  unitd --control unix:/var/run/control.unit.sock
  unitctl -s unix:/var/run/control.unit.sock import /docker-entrypoint.d/
  kill -TERM "$(cat /var/run/unit.pid)"
  rm -rf /docker-entrypoint.d/*
}

main() {
  case "$1" in
  harmonize) harmonize ;;
  esac
}

main "$@"
