listen {
  port = 4040
  address = "0.0.0.0"
}


namespace "mediawiki_nginx_prod" {
  format = "{ \"appname\": \"mediawiki-nginx-access-logs\", \"time_local\": \"$time_local\", \"remote_addr\": \"$http_fastly_client_ip\", \"remote_user\": \"$remote_user\", \"method\": \"$request_method\", \"request\": \"$request_uri\", \"status\": $status, \"body_bytes_sent\": $body_bytes_sent, \"request_time\": $request_time, \"http_host\": \"$http_x_original_host\", \"http_referrer\": \"$http_referer\", \"http_user_agent\": \"$http_user_agent\" }"
  source_files = [
    "/var/log/nginx/std.log"
  ]
  labels {
    app = "mediawiki_nginx_prod"
    environment = "dev"
  }

  histogram_buckets = [.005, .01, .025, .05, .1, .25, .5, 1, 2.5, 5, 10]
}