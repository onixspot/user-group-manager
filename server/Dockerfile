FROM onixspot/unit-php

ARG hostname
ENV HOSTNAME="$hostname"

RUN mkdir "/app"
WORKDIR "/app"

COPY . .
RUN ./bin/ssl.sh init \
 && ./bin/unit.sh harmonize

CMD [ "/app/startup.sh" ]
VOLUME [ "/app", "/var/lib/unit" ]


