<template>
    <div class="container">
        <section class="mt-2">
            <label>Ingrese su Nombre : </label>
            <input type="text" v-model="reserva.nombre" />
        </section>
        <section class="mt-2">
            <label>Ingrese su Apellido : </label>
            <input type="text" v-model="reserva.apellido" />
        </section>
        <section class="mt-2">
            <label>Ingrese la cantidad de Personas : </label>
            <input type="number" v-model="reserva.cantidad" />
        </section>
        <section class="mt-2">
            <label>Selecciona la Fecha de la Reserva : </label>
            <input type="date" v-model="reserva.fecha_reserva" />
        </section>
        <button class="btn btn-info btn-block mt-3" @click="buscarAsientos()"> Buscar Asientos</button>

        <template v-for="n in filas" v-if="verButacas">
            <div class="d-flex flex-row justify-content-between mb-3 mt-3">
                <template v-for="i in columnas">
                    <div class="">
                        <label class="super-happy">
                            <!--<input type="checkbox" class="super-happy" :disabled="i!=1 ? '' : disabled"/> -->
                            <input type="checkbox" v-model="reserva.butacas" :disabled="findArray(butacasReservadas, `${i}-${n}`)" class="super-happy" :value="`${i}-${n}`"/>
                            <svg enable-background="new 0 0 512.522 512.522" class="asiento" viewBox="0 0 512.522 512.522" xmlns="http://www.w3.org/2000/svg"><path d="m407.664 211.714-13.941-85.31c-.667-4.088-4.512-6.861-8.611-6.192-4.088.668-6.86 4.523-6.191 8.611l12.437 76.102c-63.451-12.539-129.991-15.76-197.809-9.548-4.125.378-7.163 4.028-6.785 8.153.378 4.124 4.036 7.165 8.152 6.785 66.933-6.13 132.56-2.896 195.06 9.616 10.575 2.117 18.251 11.527 18.251 22.375v23.666c0 12.592-10.244 22.836-22.836 22.836h-258.259c-12.592 0-22.836-10.244-22.836-22.836v-23.198c0-11.007 7.847-20.452 18.656-22.458 13.32-2.472 26.883-4.636 40.312-6.432 4.105-.549 6.988-4.322 6.439-8.428s-4.324-6.991-8.428-6.439c-13.679 1.829-27.493 4.033-41.06 6.551h-.001l21.091-129.681c5.739-35.281 35.846-60.887 71.589-60.887h85.787c35.716 0 65.819 25.583 71.579 60.832l3.467 21.211c.667 4.087 4.518 6.858 8.611 6.192 4.088-.668 6.86-4.524 6.191-8.612l-3.467-21.21c-3.345-20.473-13.893-39.146-29.7-52.58-15.806-13.435-35.937-20.833-56.681-20.833h-85.787c-20.757 0-40.896 7.406-56.707 20.854s-26.354 32.137-29.686 52.624l-22.686 139.487c-8.917 6.986-14.519 17.84-14.519 29.808v23.198c0 20.863 16.973 37.836 37.836 37.836h5.669l-29.245 192.741c-.608 4.006.558 8.066 3.199 11.139s6.481 4.835 10.533 4.835h7.449c6.18 0 11.525-3.976 13.303-9.894l46.575-155.031 17.1-10.594h109.09l17.1 10.594 7.559 25.161c.976 3.248 3.954 5.344 7.18 5.344.715 0 1.441-.103 2.161-.319 3.967-1.191 6.217-5.374 5.024-9.34l-19.418-64.636h34.137l29.393 193.715h-5.333l-29.582-98.468c-1.191-3.968-5.372-6.216-9.341-5.025-3.967 1.192-6.217 5.374-5.024 9.341l29.819 99.259c1.777 5.917 7.123 9.894 13.303 9.894h7.449c4.052 0 7.892-1.762 10.533-4.835s3.808-7.133 3.199-11.139l-29.245-192.741h5.669c20.863 0 37.836-16.973 37.836-37.836v-23.666c.002-12.385-6.051-23.639-15.56-30.592zm-283.752 285.808h-5.333l29.393-193.715h34.137zm197.481-171.606-2.844-1.762c-2.273-1.408-4.887-2.152-7.56-2.152h-109.457c-2.673 0-5.286.744-7.562 2.153l-2.842 1.76 6.642-22.109h116.979z"/></svg>
                        </label>
                    </div>
                </template>
            </div>
        </template>
        <template v-if="reserva.edit">                
            <button class="btn btn-success btn-block mt-3" @click="actualizarReserva()"> Actualizar Reserva</button>        
        </template>
        <template v-else>
            <button class="btn btn-success btn-block mt-3" @click="guardarReserva()"> Crear Reserva</button>        
        </template>
    </div>
</template>

<script>
import printError from '../printErrors'
export default {
    name: 'crear-reserva-component',
    props: ['reserva'],
    data(){
        return{
            filas : 5,
            columnas : 10,
            verButacas:false,
            butacasReservadas:[],
        }
    },
    methods: {
        buscarAsientos: async function () {
            let me = this;
            var url = `/buscarAsientos?fecha=${me.reserva.fecha_reserva}&cantidad=${me.reserva.cantidad}&edit=${me.reserva.edit}&id=${me.reserva.id}`;
            try{
                let response =  await axios.get(url);
                let respuesta = response.data;
                respuesta.reservas.forEach(reserva => {
                    reserva.butacas.forEach(butaca => {
                        me.butacasReservadas.push(`${butaca.columna}-${butaca.fila}`);
                    });
                });
                if(me.reserva.edit){
                    me.reserva.butacas.forEach(element =>{
                        me.butacasReservadas = me.butacasReservadas.filter( butaca => {
                            return butaca !== element
                        })
                    })
                }
                me.verButacas = true;
            }catch(error) {                
                printError(error)
            };
        },
        guardarReserva : async function(){
            let me = this;
            const url = `/reserva`;
            try {
                let response =  await axios.post(url, {
                    'nombre' : this.reserva.nombre,
                    'apellido' : this.reserva.apellido,
                    'cantidad' : this.reserva.cantidad,
                    'fecha_reserva' : this.reserva.fecha_reserva,
                    'butacas' : this.reserva.butacas
                });
                alert('Reserva realizada con exito');
                this.limpiarCampos()
            } catch (error) {
                printError(error)
            }
        },
        actualizarReserva : async function(){
            let me = this;
            const url = `/reserva/${this.reserva.id}`;
            try {
                let response =  await axios.put(url, {
                    'nombre' : this.reserva.nombre,
                    'apellido' : this.reserva.apellido,
                    'cantidad' : this.reserva.cantidad,
                    'fecha_reserva' : this.reserva.fecha_reserva,
                    'butacas' : this.reserva.butacas
                });
                alert('Reserva actualizada con exito');
                this.limpiarCampos()
            } catch (error) {
                printError(error)
            }
        },
        findArray(arr, value){
            var res = arr.find(element => element === value);
            return res;
        },
        limpiarCampos(){
            this.verButacas=false,
            this.butacasReservadas=[],
            this.$root.reserva={
                nombre:'',
                apellido:'',
                cantidad:'',
                fecha:'',
                butacas:[]
            }
        },
    },
    mounted() {
        if(this.reserva.edit){
            this.buscarAsientos()
        }
    },
}
</script>