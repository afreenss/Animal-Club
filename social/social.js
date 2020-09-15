function validatecreate() {
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