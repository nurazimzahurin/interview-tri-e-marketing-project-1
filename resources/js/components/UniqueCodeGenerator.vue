<template>
    <div class="w-100">
        <h1>Generate Unique Code</h1>
        <form @submit.prevent="submit">
            <span v-if="!timer">Insert number of rows to be generated</span>
            <Timer v-else :date="Date.now()" :pause="pause"></Timer>
            <input type="number" placeholder="Insert number of rows to be generated" v-model="form.number" class="w-100">
            <span class="text-danger pt-3 pb-3 float-left" style="font-size:10px;" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></span>
            <span class="text-danger pt-3 pb-3 float-left" style="font-size:10px;" v-if="error !== ''" v-text="error"></span>
            <button type="submit" class="btn btn-info float-right" id="hantar">Submit</button>
            <a v-if="newSession" class="btn btn-success float-right" href="/generate-code">New Session</a>
        </form>
        <br>
        <br>
        <span class="text-info float-right" style="font-size:15px;" v-if="result" v-text="loading"></span>
    </div>
</template>

<script>
import Timer from './Timer';
export default {
    data() {
        return {
            form: new Form({
                number: 1,
            }),
            timer: false,
            pause: false,
            result: false,
            loading: 'Processing...',
            newSession: false,
            error: ''
        }
    },
    methods:{
        submit(){
            let data = new FormData();
            _.forEach(this.form, (val, key) => {
                data.append(key, val || '');
            });
            this.result = true;
            this.timer = true;

            axios.post('/generate-code', data).then((res) =>{
                // setTimeout(() => this.pause = true, 1000);
                this.pause = true;
                this.loading = res.data.message;
                document.getElementById('hantar').hidden = true;
                this.newSession = true
            }).catch((error) => {
                this.pause = true;
                this.result = false;
                document.getElementById('hantar').hidden = true;
                this.newSession = true
                if (error.response.status === 422) {
                    this.form.errors.record(error.response.data.errors)
                } else {
                    this.error = 'Server Error, Contact Me';
                }
            })

        },
    },
    components: {
        Timer
    },
}
</script>
