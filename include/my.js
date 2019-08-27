// --------------------
// ---  javascript  ---
// --------------------
function Func_G_Search(nI,cID_Table)
{
    var input, filter, table, tr, td, i;

    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();

    //table = document.getElementById("uploadTable");
    table = document.getElementById(cID_Table);
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) 
    {
        td = tr[i].getElementsByTagName("td")[nI];
        if (td) 
        {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) 
            {
                tr[i].style.display = "";
            } 
            else 
            {
                tr[i].style.display = "none";
            }
        }       
    }
}