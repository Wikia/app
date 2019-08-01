local httpc = {
  set_timeout=function() end,
  request_uri=function()
    return {status=501, body=''}, nil
  end
}

return {
  new=function()
    return httpc
  end
}
