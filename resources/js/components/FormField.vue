<template >
        <default-field  :field="field" :errors="errors" class="test">
        <template slot="field" class="w-full" style="width:100% !important;">
            <div class="">
                <input
                id="widthinput"
                type="number"
                min="0"
                step="0.01"
                class="w-1/5 form-control form-input form-input-bordered"
                placeholder="width cm"
                v-model="width"
            />
            <input
                type="number"
                min="0"
                step="0.01"
                class="w-1/5 form-control form-input form-input-bordered"
                placeholder="height cm"
                v-model="height"
            />
            <input
                type="number"
                min="0"
                step="0.01"
                class="w-1/5 form-control form-input form-input-bordered"
                placeholder="length cm"
                v-model="length"
            />
            <input
                type="number"
                min="0"
                step="0.01"
                class="w-1/5 form-control form-input form-input-bordered"
                placeholder="weight kg"
                v-model="weight"
            />
            <button type="button"  class="btn btn-default items-center" style="    background: none; border: none; box-shadow: none;" @click="addItem">
                <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 20 20" class="sidebar-icon" style="vertical-align: sub;margin:0 !important;"><path fill="green" d="M15 9h-3v2h3v3h2v-3h3V9h-3V6h-2v3zM0 3h10v2H0V3zm0 8h10v2H0v-2zm0-4h10v2H0V7zm0 8h10v2H0v-2z"></path></svg>
            </button>
            <br>
            <p  v-if="error" class="mt-3" style="color:red;">All fields are required. </p>


            <table class="table w-full" style="margin-top:20px;margin-bottom:20px;">
                <thead>
                    <tr>
                    <th>Quantity</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Length</th>
                    <th>Weight</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dm in dms" :key="dm.key">
                        <td class="text-center"><p style="font-weight: bold;">x {{ dm.quantity }}</p></td>
                        <td class="text-center">{{ dm.width }}</td>
                        <td class="text-center">{{ dm.height }}</td>
                        <td class="text-center">{{ dm.length }}</td>
                        <td class="text-center">{{ dm.weight }}</td>
                        <td>
                                <button type="button" class="btn btn-default items-center" style="    background: none; border: none; box-shadow: none;"  @click="deleteItem(dm.key)">
                                    <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 20 20" class="sidebar-icon" style="vertical-align: sub;margin:0 !important;"><path fill="red" d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"></path></svg>
                                </button>
                        </td>
                    </tr>
                </tbody>
            </table>
</div>


        </template>
    </default-field>

</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import { v4 as uuidv4 } from 'uuid';


export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            width : '',
            height: '',
            length : '',
            weight: '',
            error:false,
            dms:[],
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || [];
            this.dms = this.value;
            // console.log('value');
            // console.log(this.value);
            // console.log('field value');
            // console.log(this.field.value);
            this.$children[0].$el.lastElementChild.className = "py-6 px-8 w-full";
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            //console.log("fill is called");
            if(Array.isArray(this.value)){
                formData.append(this.field.attribute, JSON.stringify(this.value)|| [])
            }else{
                formData.append(this.field.attribute, this.value|| [])
            }

            // console.log('Dms value');
            // console.log(JSON.stringify(this.dms));
            // console.log('value');
            // console.log(this.value);
            // console.log('is an array');
            // console.log(Array.isArray(this.value));
            // console.log('stringyfy value');
            // console.log(JSON.stringify(this.value));
            // console.log('field value');
            // console.log(this.field.value);
        },

        addItem(){
            if (this.width == '' || this.height == '' || this.length == '' || this.weight == '') {
                return this.error = true;
            }

            this.error = false;
            var dms = this.dms.filter((dm) => {
                return dm.width == this.width && dm.height == this.height && dm.length == this.length && dm.weight == this.weight ;
            });
            if(dms.length > 0){
                var qt = dms[0].quantity ++;
                dms.quantity = qt;

            }else{
            this.dms.push({quantity : 1,width: this.width,height: this.height,length:this.length,weight:this.weight,key:uuidv4()});
            }
            this.width ='';
            this.height='';
            this.length='';
            this.weight='';
            this.width = "";
            this.value = JSON.stringify(this.dms);
            this.field.value = this.value;
            // console.log("DMS");
            // console.log(this.value);
            //this.$refs.widthinput.focus();

            },
        deleteItem(key){
            var dmItem = this.dms.find((dm) => {
                return dm.key == key;
            });
            if(!dmItem)return;
            var index = this.dms.indexOf(dmItem);

            if(dmItem.quantity > 1){
                dmItem.quantity --;
                this.dms[index]=dmItem;
            }else{
            this.dms = this.dms.filter((dm) => {
                return dm.key !== key;
            });
            }
            // console.log("DMS");
            // console.log(this.dms);
            this.value = JSON.stringify(this.dms);
            this.field.value = this.value;
        },
    },

}
</script>
