<template>
    <div>
        <template v-if="comportamiento === 0">
            <section class="mt-2">
                <label>Selecciona la fecha a buscar : </label>
                <input type="date" v-model="fecha" />
            </section>
            <section class="mt-2">
                <label>Selecciona el apellido : </label>
                <input type="text" v-model="apellido" />
            </section>
            <button class="btn btn-info btn-block mt-3" @click="listarReservas(1)"> Buscar Reservas</button>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cantidad de Reservas</th>
                            <th scope="col">Asientos Reservados</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="reserva in arrayReservas" :key="reserva.id">
                            <td v-text="reserva.id"></td>
                            <td v-text="reserva.nombre"></td>
                            <td v-text="reserva.apellido"></td>
                            <td>
                                {{formatFecha(reserva.fecha_reserva)}}
                            </td>
                            <td v-text="reserva.cantidad"></td>
                            <td>

                                <ul v-for="butaca in reserva.butacas" :key="butaca.id">
                                    <li>
                                        Fila : {{butaca.fila}} / Columna : {{butaca.columna}}
                                    </li>    
                                </ul>
                            </td>
                            <td>
                                <button class="btn btn-info" @click="editarReserva(reserva)">
                                    Editar
                                </button>
                                <button class="btn btn-danger" @click="eliminarReserva(reserva)">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                    </li>
                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                    </li>
                </ul>
            </nav>
        </template>
        <template v-else>
            <crear-reserva-component 
                :reserva="reserva"
            />
        </template>
    </div>
</template>

<script>
import CrearReservaComponent from './CrearReservaComponent.vue'
import printError from '../printErrors'
import moment from "moment";
moment.locale("es");
export default {
    components: {
    CrearReservaComponent,
  },
  name: 'listar-reserva-component',
    data () {
        return{
            arrayReservas:[],
            fecha:moment().format('Y-MM-DD'),
            apellido:'',
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0
            },
            offset: 3,
            comportamiento:0,
            reserva:{}
        }
    },
    computed:{
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if (!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];

            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods:{
        async listarReservas(page){
            let me = this;
            var url = `/reserva?page=${page}&fecha=${me.fecha}&apellido=${me.apellido}`;
            try{
                let response =  await axios.get(url);
                let respuesta = response.data;
                me.arrayReservas = respuesta.reservas.data;
                me.pagination = respuesta.reservas;

            }catch(error) {                
                printError(error)
            };
        },
        formatFecha(fecha){
             return moment(fecha).format("LL");
        },
        cambiarPagina(page) {
            let me = this;
            // actualiza la pagina actual
            me.pagination.current_page = page;
            me.listarReservas(page);
        },
        editarReserva(reserva){
            this.$root.reserva = reserva;
            this.$root.reserva.edit = true;
            this.$root.menu = 0;
            this.$root.reserva.butacas = this.$root.reserva.butacas.map(element => {
                return `${element.columna}-${element.fila}`
            })
            this.comportamiento = 1;
        },
        async eliminarReserva(reserva){
            var url = `/reserva/${reserva.id}`;
            try{
                let response =  await axios.delete(url);
                alert('Reserva eliminada con exito');
                this.listarReservas(this.pagination.current_page)
            }catch(error) {                
                printError(error)
            };
        }
    },
    mounted(){
        this.listarReservas(1)
    }
}
</script>