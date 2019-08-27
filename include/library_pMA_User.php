
<script type="text/javascript">
    $(document).ready(function(){
        $('.btnClose').click(function(){
            //alert('.btn-clode');
            $('#insert-form')[0].reset();
        })

        /* attach a submit handler to the form */
        $("#insert-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();
            //alert("aa");
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "pMA_User_insert.php",
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
                url: "pMA_User_fetch.php",
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
                url: "pMA_User_view.php",
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
                    url: "pMA_User_delete.php",
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