<template>
    <span>{{ this.numberOfItems() }}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    created(){
        // console.log("number of itlem is");
        // console.log(this.numberOfItems());

    },
    methods: {
        numberOfItems(){
            var items = 0;
            var dms = this.field.value || [];
            var arr = [];
            dms.filter((dm) => {
                items = items + dm.quantity;
                return true;
            });
            return items;
        }
    },
}
</script>
