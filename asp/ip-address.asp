<!DOCTYPE html>
<html>
<body>
<%
response.write("<h2>Hello world!</h2>")
%>

<%
Dim sIPAddress

sIPAddress = Request.ServerVariables("HTTP_X_FORWARDED_FOR")
If sIPAddress="" Then sIPAddress = Request.ServerVariables("REMOTE_ADDR")

response.write("<p style='color:#0000ff'>Your IP Address: " & sIPAddress & "</p>")
response.write("<p style='color:#0000ff'>The Server IP Address: " & Request.ServerVariables("LOCAL_ADDR") & "</p>")
%>
</body>
</html>