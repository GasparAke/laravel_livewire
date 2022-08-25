<div class="mt-5">

    <div>

        <select class="from-control" id="select2-dropdown">
            <option value="">Seleccionar Producto</option>
            @foreach($products as $p)
            <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#select2-dropdown').select2() //inicializar
        //capturamos los valores
        $('#select2-dropdown').on('change', function (e) {
            var pId =$('#select2-dropdown').select2("val")
            var pName = $('#select2-dropdown option:selected').text()
            @this.set('productSelectedId', pId)  
            @this.set('productSelectedName', pName)  
        }); 
    });
</script>