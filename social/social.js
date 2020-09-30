function validatecreate() 
{
    var fname= document.forms["createacc"]["username"].value;
    var femail= document.forms["createacc"]["email"].value;
    var fpass= document.forms["createacc"]["password"].value;

    if(femail == "")
    {
        alert("Please provide email!");
        return false;
    } 
    else if(fpass == "")
    {
        alert("Please provide password !");
        return false;
    }
    else if(fname == "")
    {
        alert("Please provide your first name!");
        return false;
    }
    else if(fname != "")
    {
        var re = /^\w+$/;
        if (!re.test(field.value)) {
            alert("Username must only contain numbers and letters ! ");
            return false;
        }
        else{
            return true;          
        }
    }
    
}
function validatepass()
{
    var oldp= document.forms["changepassword"]["oldpass"].value;
    var newp1= document.forms["changepassword"]["newpass"].value;
    var newp11= document.forms["changepassword"]["newpass1"].value;

    if(oldp == "")
    {
        alert("Please provide your old password!");
        return false;
    } 
    else if(newp == "")
    {
        alert("Please provide a new password !");
        return false;
    }
    else (newp1 == "")
    {
        alert("Please retype your new password!");
        return false;
    }

}