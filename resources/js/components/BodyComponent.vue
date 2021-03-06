<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Reserva tu Butaca Para el Teatro</div>
                    <div class="card-body">
                        <reserva></reserva>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import reserva from './ReservaComponent'
    export default {
        components:{
            reserva
        }
    }
</script>
