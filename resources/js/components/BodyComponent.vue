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
                                <template v-if="this.$root.menu === 0">
                                    <button class="btn btn-success  float-right" @click="cambiarVista(1)">
                                        Ver Reservas
                                    </button>
                                </template>

                                <template v-else>
                                    <button class="btn btn-success  float-right" @click="cambiarVista(0)">
                                        Crear Reserva
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <template v-if="this.$root.menu === 0">
                            <crear-reserva-component 
                                :reserva="this.$root.reserva"
                            />
                        </template>
                        <template v-else>
                            <listar-reserva-component></listar-reserva-component>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CrearReservaComponent from './CrearReservaComponent.vue'
    import ListarReservaComponent from './ListarReservaComponent.vue'
    import moment from "moment";
    moment.locale("es");
    export default {
        components: {
            CrearReservaComponent,
            ListarReservaComponent,
        },
        name:'body-component',
        data(){
            return{
            }
        },
        methods:{
            cambiarVista(n){
                this.$root.menu = n;
                this.$root.reserva = {
                    nombre:'',
                    apellido:'',
                    cantidad:'',
                    fecha_reserva:moment().format('Y-MM-DD'),
                    butacas:[],
                    edit : false,
                }
            },
        }
    }
</script>
