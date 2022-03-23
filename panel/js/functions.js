function Myconfirm(Str,Url)
{
	if (confirm(Str))
   {
		document.location = Url;
	}
}

function Myconfirm2(Str,Url)
{
	if (confirm(Str))
   	{
		window.open(Url,"_blank","");
	}
}

function Gfx(pic,x,y)
{
    var s='<html><head><TITLE>SFOL</TITLE><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"></head>\n';
     s=s+'<body BGCOLOR="#ffffff" MARGINWIDTH=0 MARGINHEIGHT=0 TOPMARGIN=0 LEFTMARGIN=0>\n';
    s=s+'<A HREF="javascript:close()"><IMG ALT="Close..." BORDER=0 SRC="'+pic+'"></A>\n';
    s=s+'</body></html>';

    var f = null;
    f = window.open('','','width='+x+',height='+y+',left=50,top=20,resizable=1,directories=0,location=0,menubar=0,scrollbars=0,status=0,toolbar=0');
    if(f != null) {
        if(f.opener == null) {
          f.opener = self
        }
        f.document.clear();
        f.document.write(s);
        f.document.close();
    }
}
