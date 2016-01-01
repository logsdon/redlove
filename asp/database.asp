<!DOCTYPE html>
<html>
<body>
<%
response.write("<h2>Hello world!</h2>")
%>

<%
response.write("<p style='color:#0000ff'>This is output from ASP.</p>")
%>

<h2>SQL Server 2012</h2>

<h3>Quick Connection Test</h3>

<%
'declare variables
dim db_database
dim db_username
dim db_password
dim db_hostname
db_database=""
db_username=""
db_password=""
db_hostname=""

Dim conn, rs

Set conn=Server.CreateObject("ADODB.Connection")
conn.Open "Provider=SQLOLEDB;server=" & db_hostname & ";Database=" & db_database & ";uid=" & db_username & ";pwd=" & db_password & ""
set rs = Server.CreateObject("ADODB.RecordSet")
%>


<h3>Connection and Query Test to the Contact Table</h3>

<%
'declare the variables
Dim Connection
Dim ConnString
Dim Recordset
Dim SQL

'define the connection string, specify database driver
ConnString="DRIVER={SQL Server};" & _
"SERVER=" & db_hostname & ";" & _
"UID=" & db_username & ";" & _
"PWD=" & db_password & ";" & _
"DATABASE=" & db_database & ""

'declare the SQL statement that will query the database
SQL = "SELECT * FROM Contact"

'create an instance of the ADO connection and recordset objects
Set Connection = Server.CreateObject("ADODB.Connection")
Set Recordset = Server.CreateObject("ADODB.Recordset")

'Open the connection to the database
Connection.Open ConnString

'Open the recordset object executing the SQL statement and return records
Recordset.Open SQL,Connection

'first of all determine whether there are any records
If Recordset.EOF Then
Response.Write("No records returned.")
Else
'if there are records then loop through the fields
Do While NOT Recordset.Eof
Response.write Recordset("Name") & " - " & Recordset("Email")
Response.write "<br>"
Recordset.MoveNext
Loop
End If

'close the connection and recordset objects to free up resources
Recordset.Close
Set Recordset=nothing
Connection.Close
Set Connection=nothing
%>

</body>
</html>