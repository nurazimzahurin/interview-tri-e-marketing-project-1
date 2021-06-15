<template>
    <span>{{days}} days {{hours}} hours {{ minutes}} minutes {{ seconds}} seconds</span>
</template>

<script>
export default {
    props:{
        date:{
            required:true
        },
        pause:{
            required:true
        }
    },
    data() {
        return {
            interval:null,
            days:0,
            hours:0,
            minutes:0,
            seconds:0,
            intervals:{
                second: 1000,
                minute: 1000 * 60,
                hour: 1000 * 60 * 60,
                day: 1000 * 60 * 60 * 24
            }
        }
    },
    mounted() {
        this.interval = setInterval(() => {
            if (!this.pause) {
                this.updateDiffs();
            }
        },1000);

        this.updateDiffs();
    },
    destroyed() {
        clearInterval(this.interval);
    },
    methods: {
        updateDiffs() {
            let diff = Math.abs(Date.now() - this.date);
            this.days = Math.floor(diff / this.intervals.day);
            diff -= this.days * this.intervals.day;
            this.hours = Math.floor(diff / this.intervals.hour);
            diff -= this.hours * this.intervals.hour;
            this.minutes = Math.floor(diff / this.intervals.minute);
            diff -= this.minutes * this.intervals.minute;
            this.seconds = Math.floor(diff / this.intervals.second);
        }
    }
}
</script>
