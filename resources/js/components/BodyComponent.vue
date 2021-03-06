<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 mt-2">
                                Reserva tu Butaca Para el Teatro
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success  float-right">
                                    Ver Reservas
                                </button>
                            </div>
                        </div>
                    </div>
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
