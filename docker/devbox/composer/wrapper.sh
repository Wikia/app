#!/usr/bin/env bash

# Add local user
# Either use the LOCAL_USER_ID if passed in at runtime or
# fallback

USER_ID=${LOCAL_USER_ID:-9001}

echo "Starting with UID : $USER_ID"
adduser --home /app --shell /bin/bash --disabled-login --uid $USER_ID --system docker_user
export HOME=/app

set -Eeo pipefail

exec gosu docker_user "$@"
