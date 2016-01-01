<!DOCTYPE html>
<html>
<body>

<%
If Request.Form.Count > 0 Then
   
	'Sends an email
	Dim mail
	Set mail = Server.CreateObject("CDO.Message")
	mail.To = Request.Form("To")
	mail.From = Request.Form("From")
	mail.Subject = Request.Form("Subject")
	mail.TextBody = Request.Form("Body")
	mail.Send()
	Response.Write("Mail Sent!<hr />")
	'Destroy the mail object!
	Set mail = nothing
	
End If
%>

<form method="POST" action="asp_email-test.asp">
To <input type="text" name="To"/> <br />
From <input type="text" name="From"/> <br />
Subject <input type="text" name="Subject"/> <br />
Body <textarea name="Body" rows="5" cols="20" wrap="physical" > 
</textarea>
<input type="submit" />
</form>

</body>
</html>