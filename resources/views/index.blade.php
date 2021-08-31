<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Encryptor</title>

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{asset('css/sweet-alert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/steps.css')}}" rel="stylesheet">

</head>
<body>
<div id="vue-app" class="pt-4 w-100">
    <h1 class="text-center">AESEncryptor</h1>
    <section class="w-100">
        <div class="container w-100">
            <div class="accordion w-100" id="accordionExample">
                <div class="steps">
                    <progress id="progress" :value="progress" max="100" ></progress>
                    <div class="step-item">
                        <button :class="'step-button text-center '+activeStepText(1, '', 'done')+ ' ' + activeStepText(2, 'collapsed', '')" type="button" data-toggle="collapse"
                                data-target="#collapseOne" v-bind:aria-expanded="activeStepText(1, 'true', 'false')" aria-controls="collapseOne">
                            1
                        </button>
                        <div class="step-title">
                            Choose File
                        </div>
                    </div>
                    <div class="step-item">
                        <button :class="'step-button text-center '+activeStepText(3, 'done', '') + ' ' + activeStepText(2, '', 'collapsed')" type="button" data-toggle="collapse"
                                data-target="#collapseTwo" v-bind:aria-expanded="activeStepText(2, 'true', 'false')" aria-controls="collapseTwo">
                            2
                        </button>
                        <div class="step-title">
                            Choose Operation
                        </div>
                    </div>
                    <div class="step-item">
                        <button :class="'step-button text-center '+activeStepText(3, '', 'collapsed')" type="button" data-toggle="collapse"
                                data-target="#collapseThree" v-bind:aria-expanded="activeStepText(3, 'true', 'false')" aria-controls="collapseThree">
                            3
                        </button>
                        <div class="step-title">
                            Get Result
                        </div>
                    </div>
                </div>
                <div id="collapseOne" :class="'collapse '+activeStepText(1, 'show', '')" aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card p-2">
                        <div class="card-header" id="headingOne">
                            <h2>Choose File</h2>
                        </div>
                        <div class="card-body">
                            <form @submit="uploadFile()" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="fileInput" class="form-label">File</label>
                                    <div class="input-group has-validation">
                                    <input type="file" :class="'form-control ' + ('input' in errors? 'is-invalid' : '')" id="fileInput" aria-describedby="fileHelp" required name="input">
                                    <div class="invalid-feedback"  v-if="'input' in errors">
                                        <p v-for="error in errors.input">[[error]]</p>
                                    </div>
                                    </div>
                                    <div id="fileHelp" class="form-text">Max file size allowed {{ max_file_upload() }}</div>
                                </div>
                                <div class="w-100 text-end">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="collapseTwo" :class="'collapse '+activeStepText(2, 'show', '')" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card p-2 mb-1" v-if="selectedFile">
                        <div class="card-header">
                            <h2>Selected File Details</h2>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                        [[selectedFile.original_name]]
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        File Size
                                    </th>
                                    <td>
                                        [[selectedFile.size]]
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Extension
                                    </th>
                                    <td>
                                        [[selectedFile.extension]]
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <form @submit="changeFile()">
                                @csrf
                                <div class="w-100 text-end">
                                    <button type="submit" class="btn btn-danger ">Change File</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card p-2" v-if="selectedFile">
                        <div id="headingTwo" class="card-header">
                            <h2>Choose Operation</h2>
                        </div>
                        <div class="card-body">
                            <form @submit="performOperation()">
                                @csrf
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="operation" id="encryptRadio" value="encrypt" v-model="operation">
                                    <label class="form-check-label" for="encryptRadio">
                                        Encrypt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="operation" id="decryptRadio" value="decrypt" v-model="operation">
                                    <label class="form-check-label" for="decryptRadio">
                                        Decrypt
                                    </label>
                                </div>
                                <div class="w-100 text-end">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="collapseThree" :class="'collapse '+activeStepText(3, 'show', '')" aria-labelledby="headingThree"
                     data-parent="#accordionExample">
                    <div class="card p-2" v-if="selectedFile">
                        <div class="card-header" id="headingThree">
                            <h2>Result</h2>
                        </div>
                        <div class="card-body">
                            <div class="text-center" v-if="selectedFile.status === 'inQueue'">
                                <div class="spinner-border text-warning" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-warning">Job In Queue</p>
                            </div>
                            <div class="text-center" v-if="selectedFile.status === 'running'">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-primary">Job Is running now</p>
                            </div>
                            <div class="text-center" v-if="selectedFile.status === 'success'">
                                <h2 class="text-success"><i class="bi bi-check-lg"></i></h2>
                                <p class="text-success">Job Finished Successfully</p>
                                <form @submit="function () {event.preventDefault();}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="downloadFileName" class="col-form-label col-sm-2 offset-sm-2 text-end">Download File Name: </label>
                                        <div class="col-sm-6 ps-0">
                                        <input type="text" class="form-control" id="downloadFileName" aria-describedby="downloadFileNameHelp" required v-model="downloadFileNAme">
                                        </div>
                                    </div>
                                </form>
                                <form @submit="changeFile()" class="d-inline-block">
                                    @csrf
                                    <div class="w-100">
                                        <button type="submit" class="btn btn-primary ">Run Another Task</button>
                                    </div>
                                </form>
                                <a class="btn btn-secondary" :download="downloadFileNAme" :href="downloadLink">Download Resulting File</a>
                                <form @submit="useFile()" class="d-inline-block">
                                    @csrf
                                    <div class="w-100">
                                        <button type="submit" class="btn btn-primary ">Use Resulting File</button>
                                    </div>
                                </form>
                                <div class="text-start">
                                <ul>
                                    <li>File is available for download for only <u>one hour.</u></li>
                                    <li><u>Running another task</u>, or <u>using the resulting file</u> will <b>overwrite the current file</b> and start a new task.</li>
                                </ul>
                                </div>
                            </div>
                            <div class="text-center" v-if="selectedFile.status === 'failed'">
                                <h2 class="text-danger"><i class="bi bi-x-lg"></i></h2>
                                <p class="text-danger">Job Failed</p>
                                <form @submit="changeFile()">
                                    @csrf
                                    <div class="w-100">
                                        <button type="submit" class="btn btn-danger ">Try Again</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="//cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
<script src="{{asset('js/sweet-alert.min.js')}}"></script>

<script>
    if (! localStorage.getItem('token')){
        localStorage.setItem('token', "{{session()->get('token')}}");
    }

    axios.defaults.baseURL = "{{config('app.url')}}";
    axios.defaults.withCredentials = true;
    const config = {
        headers: { token: localStorage.getItem('token'), Accept: 'application/json' }
    };
    axios.defaults.headers.common = config.headers;

    var vm = new Vue({
        el: "#vue-app",
        delimiters: ['[[', ']]'],
        data: {
            selectedFile: null,
            operation: 'encrypt',
            timer: null,
            downloadFileNAme: null,
            errors: {}
        },
        mounted: function (){
            this.updateFile();
        },
        watch: {
          selectedFile: function (newFile, oldFile){
              this.downloadFileNAme = newFile ? newFile.original_name : null;
              if (newFile && newFile.status){
                  if (newFile.status !== 'success' && newFile.status !== 'failed'){
                      if (! this.timer) this.startTimer();
                  }
                  else {
                      this.stopTimer();
                  }
              }
              else{
                  this.stopTimer();
              }
          }
        },
        computed: {
            activeStep: function (){
                if (! this.selectedFile){
                    return 1;
                }
                else if (! this.selectedFile.status){
                    return 2;
                }
                else{
                    return 3;
                }
            },
            progress: function (){
                return 100*(this.activeStep-1)/2;
            },
            downloadLink: function () {
                    return '{{asset('storage/random')}}'.replace('random', this.selectedFile.output_path);
            }
        },
        methods: {
            downloadFile(){
                let vue = this;
                window.saveAs('{{asset('storage/random')}}'.replace('random', vue.selectedFile.output_path), vue.downloadFileNAme)
            },
            updateFile(){
                const vue = this;
                axios.get("{{route('api.lastFile')}}")
                    .then(function (response){
                        if (response.data.status === 1){
                            vue.selectedFile = response.data.selectedFile;
                        }
                    })
                    .catch(vue.handleError);
            },
            startTimer(){
                const vue = this;
                vue.timer = setInterval(vue.updateFile, 5000);
            },
            stopTimer(){
                const vue = this;
                if (vue.timer) {
                    clearInterval(vue.timer);
                    vue.timer = null;
                }
            },
            useFile(){
                const vue = this;
                event.preventDefault();
                let form = new FormData(event.target);
                axios.post("{{route('api.useFile')}}", form)
                    .then(function (response) {
                        if (response.data.status === 1){
                            vue.selectedFile = response.data.selectedFile;
                        }
                    })
                    .catch(vue.handleError)
            },
            performOperation(){
                const vue = this;
                event.preventDefault();
                let form = new FormData(event.target);
                axios.post(`api/${vue.operation}`, form)
                    .then(function (response) {
                        if (response.data.status === 1){
                            vue.selectedFile = response.data.selectedFile;
                        }
                    })
                    .catch(vue.handleError)
            },
            activeStepText(step, on, off){
                return this.activeStep === step ? on : off;
            },
            uploadFile(){
                const vue = this;
                event.preventDefault();
                let form = new FormData(event.target);
                axios.post("{{route('api.uploadFile')}}", form)
                    .then(function (response){
                        if (response.data.status === 1){
                            vue.errors = {};
                            vue.selectedFile = response.data.selectedFile;
                        }
                    })
                    .catch(vue.handleError);
            },
            changeFile(){
                const vue = this;
                event.preventDefault();
                let form = new FormData(event.target);
                axios.post("{{route('api.changeFile')}}", form)
                    .then(function (response){
                        if (response.data.status === 1){
                            vue.selectedFile = response.data.selectedFile;
                        }
                    })
                    .catch(vue.handleError);
            },
            handleError(err) {
                if (err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
                else {
                    swal(
                        {
                            title:"Oops",
                            text:"Something has gone wrong, please try again later.",
                            type:"error",
                            confirmButtonClass:"btn-danger",
                        });
            }
        }
        }
    });
</script>
</body>
</html>
