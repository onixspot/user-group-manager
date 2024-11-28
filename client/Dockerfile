FROM onixspot/php-cli

WORKDIR "/app"

COPY . .
COPY --from=api/server /ssl/* /usr/local/share/ca-certificates/
RUN update-ca-certificates

ENTRYPOINT [ "/app/entrypoint.sh" ]
VOLUME "/app"