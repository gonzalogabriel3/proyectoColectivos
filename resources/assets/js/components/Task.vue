        <template>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button @click="initAddTask()" class="btn btn-primary btn-xs pull-right">
                                    + Add New Task
                                </button>
                                My Tasks
                            </div>

                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-responsive" v-if="tasks.length > 0">
                                    <tbody>
                                    <tr>
                                        <th>
                                            No.
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    <tr v-for="task in tasks" :key="task.id">
                                        <td>{{ task.id }}</td>
                                        <td>
                                            {{ task.name }}
                                        </td>
                                        <td>
                                            {{ task.description }}
                                        </td>
                                        <td>
                                            <button @click="initUpdate(task.id)" class="btn btn-success btn-xs">Edit</button>
                                            <button @click="deleteTask(task.id)" class="btn btn-danger btn-xs">Delete</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" tabindex="-1" role="dialog" id="add_task_model">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Add New Task</h4>
                            </div>
                            <div class="modal-body">

                                <div class="alert alert-danger" v-if="errors.length > 0">
                                    <ul>
                                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" placeholder="Task Name" class="form-control"
                                           v-model="task.name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <div id="Punto">
                                        <label for="new-todo">Add a Punto</label>
                                        <ul v-for="punto in puntos">
                                            <li>
                                                {{punto.id}}: {{punto.latitud}} // {{punto.longitud}}
                                            </li>
                                        </ul>
                                        <form @submit.prevent="crearPunto" class="form">
                                            
                                            <label for="nuevo punto">Latitud</label>
                                            <input v-model="nuevoPunto.latitud" type="text" name="latitud">

                                            <label for="nuevo punto">Longitud</label>
                                            <input v-model="nuevoPunto.longitud" type="text" name="longitud">
                                            
                                            <button type="submit" class="btn btn-primary">agregar punto</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" @click="createTask" class="btn btn-primary">Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <div class="modal fade" tabindex="-1" role="dialog" id="update_task_model">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Update Task</h4>
                            </div>
                            <div class="modal-body">
         
                                <div class="alert alert-danger" v-if="errors.length > 0">
                                    <ul>
                                        <li v-for="error in errors" :key="error.id">{{ error }}</li>
                                    </ul>
                                </div>
         
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" placeholder="Task Name" class="form-control"
                                           v-model="update_task.name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea cols="30" rows="5" class="form-control"
                                              placeholder="Task Description" v-model="update_task.description"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" @click="updateTask" class="btn btn-primary">Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </template>

<script>
    export default {
        data(){
                return {
                    task: {
                        name: '',
                        description: ''
                    },
                    nuevoPunto:{
                        latitud:'',
                        longitud:''
                    },
                    errors: [],
                    tasks: [],
                    update_task: [],
                    puntos: [
                          {
                            latitud: '-43.1231',    
                            longitud: '-69.3211'
                          },
                        ],
                }
        },
                mounted()
                {
                    this.readTasks();
                },
                methods: {
                    initAddTask()
                    {
                        $("#add_task_model").modal("show");
                    },
                    createTask()
                    {
                        axios.post('/task', {
                            name: this.task.name,
                            description: this.task.description,
                            
                        })
                            .then(response => {
                                
                                this.readTasks();
                                
                                this.reset();

                                $("#add_task_model").modal("hide");


                            })
                            .catch(error => {
                                this.errors = [];
                                if (error.errors != undefined && error.errors.name != undefined) {
                                    this.errors.push(error.errors.name[0]);
                                }

                                if (error.errors != undefined && error.errors.description != undefined) {
                                    this.errors.push(error.errors.description[0]);
                                }
                            });
                    },
                    reset()
                    {
                        this.task.name = '';
                        this.task.description = '';
                    },
                    resetUpdate()
                    {
                        this.update_task.name = '';
                        this.update_task.description = '';
                    },
                    readTasks()
                    {
                        axios.get('/task')
                            .then(response => {

                                this.tasks = response.data.tasks;

                            });
                    },
                    initUpdate(id)
                    {
                        this.errors = [];
                        $("#update_task_model").modal("show");
                        this.update_task = this.tasks[id];
                    },
                    updateTask()
                    {
                         axios.patch('/task/' + this.update_task.id, {
                            name: this.update_task.name,
                            description: this.update_task.description,
                        })
                            .then(response => {
         
                                $("#update_task_model").modal("hide");
         
                            })
                            .catch(error => {
                                this.errors = [];
                                if (error.response.data.errors.name) {
                                    this.errors.push(error.response.data.errors.name[0]);
                                }
         
                                if (error.response.data.errors.description) {
                                    this.errors.push(error.response.data.errors.description[0]);
                                }
                            });
                    },
                    crearPunto() {
                        this.puntos.push(this.nuevoPunto);
                        this.nuevoPunto = {latitud:'',longitud:''};
                    },
                    deleteTask(id)
                    {
                        let conf = confirm("De verdad quiere borrar esta tarea?");
                        if (conf) {

                            axios({
                                method:'delete',
                                url:'/task/'+id
                                })
                                .then(
                                    response => {
                                        this.readTasks();

                                    
                                })
                                .catch(error => {

                                });
                        }
                    },
                }
            }

</script>