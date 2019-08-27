
<script type="text/javascript">
    /*
    function showModalUpdate_User_Master(argument1,argument2,argument3,argument4,argument5,argument6)
    {
        $('#paramupdate_emp_code').val(argument1);
        $('#update_emp_code').val(argument1);
        $('#update_emp_tfname').val(argument2);
        $('#update_emp_tlname').val(argument3);
        $('#update_user_email').val(argument4);
        $('#update_user_type').val(argument5);
        $('#update_user_create_date').val(argument6);

        // show modal
        $('#update_record_modal').modal('show');
        //document.getElementById("edit_Fname").innerHTML = A;
    }

    function showModalDelete_User_Master(argument1,argument2,argument3,argument4,argument5,argument6)
    {
        $('#paramdelete_emp_code').val(argument1);
        $('#delete_emp_code').val(argument1);
        $('#delete_emp_tfname').val(argument2);
        $('#delete_emp_tlname').val(argument3);
        $('#delete_user_email').val(argument4);
        $('#delete_user_type').val(argument5);
        $('#delete_user_create_date').val(argument6);
                
        // show modal
        $('#delete_record_modal').modal('show');
        //document.getElementById("edit_Fname").innerHTML = A;
    }
    */

    $(document).ready(function(){
        /* attach a submit handler to the form */
        $("#insert-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();
            //alert("aa");
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "insert.php",
                method: "post",
                data: $('#insert-form').serialize(),
                beforeSend:function(){
                    $('#insert').val('Insert...')
                },
                success: function(data){
                    if (data == '') {
                        $('#insert-form')[0].reset();
                        $('#insert_modal').modal('hide');
                        location.reload();
                    }
                    else
                    {
                        alert(data);
                        location.reload();
                    }
                }
            });   
        });

        $('.edit_data').click(function(){
            var code = $(this).attr("emp_code");
            $.ajax({
                url: "fetch.php",
                method: "post",
                data: {id: code},
                dataType: "json",
                success: function(data)
                {
                    $('#editempCode').val(data.emp_code);
                    $('#empCode').val(data.emp_code);
                    $('#eMail').val(data.user_email);
                    $('#userType').val(data.user_type);
                    $('#createdDate').val(data.user_create_date);
                    $('#insert_modal').modal('show');
                }
            });            
        });

        $('.view_data').click(function(){
            var code = $(this).attr("emp_code");
            $.ajax({
                url: "view.php",
                method: "post",
                data: {id: code},
                success: function(data){
                    $('#detail').html(data);
                    $('#view_modal').modal('show');
                }
            });            
        });

        $('.delete_data').click(function(){
            var code = $(this).attr("emp_code");            
            var lConfirm = confirm("Do you want to delete this record?");
            if (lConfirm)
            {                
                $.ajax({
                    url: "delete.php",
                    method: "post",
                    data: {id: code},
                    success: function(data){
                        location.reload();
                    }
                });  
            } 
        });
    });

</script>