<template>
<div>
    <!--div donde se va a contener el mapa-->
    <div id="mapid" style="width: 600px; height: 400px;">
    <!-- Contenedor del Mapa -->
    </div>

    <!--BOTONES PARA LAS ACCIONES-->
    <button class="btn btn-info" @click="mostrarParadas">Mostrar Paradas</button>
    <button class="btn btn-success" @click="showModalRecorrido">Mostrar un Recorrido</button>

    <!--MODAL para seleccionar un recorrido-->
    <div class="modal show" id="anadir" v-if="modalRecorrido" tabindex="-1" role="dialog" aria-labelledby="anadir">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="closeModalRecorrido" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Eliga un Recorrido</h4>
                    </div>
                    <div class="modal-body" >
                        <select v-model="recorrido_identificador">
                            <option disabled value="">--Seleccione un recorrido--</option>
                            <option v-for="recorrido in recorridos" :key="recorrido.id" v-bind:value="recorrido.id">{{recorrido.nombre}}</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" @click="BuscarRecorrido()" v-if="recorrido_identificador">Mostrar recorrido</button>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!--FIN DEL MODAL para seleccionar un recorrido-->

</div>
</template>
<script>
export default {
    data(){
        return {
            modalRecorrido:false,
            recorrido_identificador:'',
            recorridos:[],
            paradas:null,
            puntosRecorrido:null,
            mapa:[]//Variable donde se va a contener el mapa principal
        }
    },
    mounted()
    {
        this.Leer();
        this.mapa=this.GenerarMapa();
    },
    methods:{
        GenerarMapa(){
            /*Genero el mapa*/
                var mymap = L.map('mapid').setView([-43.2991348,-65.1056655], 13);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets',
            updateWhenIdle: true,
            reuseTiles: true

        }).addTo(mymap);
            return mymap;
        },
        mostrarParadas(){

           for (i = 0; i < paradas.length; i++) { 
                var marker = L.marker([-43.3081713,-65.0521686]).addTo(mymap).bindPopup('<b>Usted esta aqui</b>').openPopup();
            }

        }
        BuscarRecorrido(id){
            this.puntosRecorrido === null;
            

            //Cargo los puntos del recorrido seleccionado
             axios.get("/task/"+this.recorrido_identificador).then(response => {
                this.puntosRecorrido = response.data.puntos;
            })
            //console.log(this.puntosRecorrido);

            if(polyline === undefined){
                var polyline = L.polyline(this.puntosRecorrido, {color: 'red'}).addTo(this.mapa);                
            } else {
                this.mapa.removeLayer(polyline);// For hide
                var polyline = L.polyline(this.puntosRecorrido, {color: 'red'}).addTo(this.mapa);
            }
            this.closeModalRecorrido();

        },
        Leer(){
            //Cargo recorridos
            axios.get("/recorrido").then(response => {
                this.recorridos = response.data.recorridos;
            });
            //Cargo un recorrido
            axios.get("/task").then(response => {
                this.puntosRecorrido = response.data.puntos;
            });
        },
        AgregarLineString(){

       
        // zoom the map to the polyline
       //this.mapa.fitBounds(polyline.getBounds());
        
        /*---- FIN DE LINESTRING ----*/
        },
        //MODALS funciones
        showModalRecorrido(){
            this.modalRecorrido=true;
        },
        closeModalRecorrido(){
            this.modalRecorrido=false;
        }
    }
}   
</script>