$(document).ready(function(){
    $('#sort').on('change',function(){
        var sort=$(this).val();
        var campaignid=window.campaignid;
        //alert(value);

        $.ajax({
            url:"server.php",
            type:"POST",
            data:{
                'sort':sort,
                'campaignid':campaignid
            },


            beforeSend:function(){
                $(".mt-2.row.g-4").html('Loading...');
            },
            success:function(data){
                $(".mt-2.row.g-4").html(data);
            }
        })

    })
})