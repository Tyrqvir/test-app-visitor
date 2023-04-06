FROM alpine:latest

RUN apk add --no-cache wrk

CMD ["wrk", "-t8", "-c2000", "-d30s", "http://nginx:80/visits"]