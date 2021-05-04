<template>

        <div class="flex border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">{{this.field.name}}</h4>
            </div>
            <div class="w-3/4 py-4 break-words">
                <table class="table w-full" >
                        <thead>
                            <tr>
                            <th>Quantity</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Length</th>
                            <th>Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dm in this.field.value" :key="dm.key">
                                <td class="text-center"><p style="font-weight: bold;">x {{ dm.quantity }}</p></td>
                                <td class="text-center">{{ Number(dm.width) }}</td>
                                <td class="text-center">{{ Number(dm.height) }}</td>
                                <td class="text-center">{{ Number(dm.length) }}</td>
                                <td class="text-center">{{ Number(dm.weight) }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],

}
</script>
