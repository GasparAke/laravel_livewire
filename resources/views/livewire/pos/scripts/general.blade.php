<script>
    document.addEventListener('DOMContentLoaded', function(){
    $('.tblscroll').niceScroll({
        cursorcolor: "#515365",
        cursorwidth: "30px",
        background: "rgba(20,20,20,0.3)",
        cursorborder: "0px",
        cursorborderradius:3
    })

    // cuando la modal se ha cargado, ponemos focus en la caja buscador
    $('#modalSearchProduct').on('shown.bs.modal', function() {
        $('#modal-search-input').focus()
    })
})


    function Confirm(id, eventName, text)
    {
        swal({
            title: 'CONFIRMAR',
            text: text,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar',
        }).then(function(result){
            if(result.value){
                window.livewire.emit(eventName, id)
                swal.close()
            }
        })
    
    }




</script>