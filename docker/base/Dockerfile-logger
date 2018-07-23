FROM alpine:3.8

RUN apk add --no-cache socat

USER 65534:65534
CMD ["socat", "-u", "TCP-LISTEN:9999,reuseaddr,fork", "-"]
