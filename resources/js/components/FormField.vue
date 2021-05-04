<template >
        <default-field  :field="field" :errors="errors" class="test">
        <modal v-if="showconfirmation">
        <form @submit.prevent="" class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 460px;"><div class="p-8"><h2 class="mb-6 text-90 font-normal text-xl">Delete Item</h2> <p class="text-80 leading-normal">
            Are you sure you want to delete this item?
          </p></div> <div class="bg-30 px-6 py-3 flex"><div class="ml-auto">

        <button type="button" data-testid="cancel-button" dusk="cancel-delete-button" class="btn text-80 font-normal h-9 px-3 mr-3 btn-link" @click="handleClose">
          Cancel
        </button>

        <button id="confirm-delete-button" data-testid="confirm-button" @click="handleConfirm(selecteditem)" type="submit" class="btn btn-default btn-danger">
          Delete
        </button>

        </div>
        </div>
        </form>
        </modal>
        <template slot="field" class="w-full" style="width:100% !important;">
            <div class="">
                <input
                ref="widthinput"
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
            <ul  v-if="error" class="mt-3" style="color:red;" >
                <li v-for="error_message in dms_errors" :key="error_message">
                    {{error_message}}
                </li>
            </ul>


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
                        <td class="text-center">
                            <div class="inline-block">
                            <button  :disabled="dm.quantity == 1" type="button" class="inline-block btn btn-danger mr-2 px-2 pb-1 items-center rounded-full focus:outline-none" @click="minusQuantity(dm)">-</button>
                             <div class="text-center inline-block" style="width:40px;">
                                 <b style="font-weight: bold; ">{{dm.quantity}}</b>
                             </div>
                             <button type="button" class="inline-block btn btn-danger ml-2 px-2 pb-1 rounded-full items-center focus:outline-none" style="background-color: green;" @click="plusQuantity(dm)">+</button>
                            </div>
                        </td>
                        <td class="text-center">{{ Number(dm.width) }}</td>
                        <td class="text-center">{{ Number(dm.height) }}</td>
                        <td class="text-center">{{ Number(dm.length) }}</td>
                        <td class="text-center">{{ Number(dm.weight) }}</td>
                        <td>
                                <button type="button" class="btn btn-default items-center" style="    background: none; border: none; box-shadow: none;"  @click="showModal(dm.key)">
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
            dms_errors:[],
            dms:[],
            showconfirmation:false,
            selecteditem:null,
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
        fill(formData) {
            this.value = JSON.stringify(this.dms);
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
            this.dms_errors=[];
            if (this.width == '' || this.height == '' || this.length == '' || this.weight == '') {
                this.dms_errors.push("All fields are required.");
                return this.error = true;
            }
            if (Number(this.width) <= 0) {
                this.dms_errors.push("Width must be more than 0.");
            }
            if (Number(this.height) <= 0) {
                this.dms_errors.push("Height must be more than 0.");
            }
            if (Number(this.length) <= 0) {
                this.dms_errors.push("Length must be more than 0.");
            }
            if (Number(this.weight) <= 0) {
                this.dms_errors.push("Weight must be more than 0.");
            }
            if (this.dms_errors.length>0) {
                this.error = true;
                return;
            }

            this.error = false;
            var dms = this.dms.filter((dm) => {
                return dm.width == this.width && dm.height == this.height && dm.length == this.length && dm.weight == this.weight ;
            });
            if(dms.length > 0){
                var qt = dms[0].quantity ++;
                dms.quantity = qt;

            }else{
            this.dms.push({quantity : 1,width: String(Number(this.width)),height: String(Number(this.height)),length:String(Number(this.length)),weight:String(Number(this.weight)),key:uuidv4()});
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
            this.$refs.widthinput.focus();

        },
        deleteItem(key){

            // var dmItem = this.dms.find((dm) => {
            //     return dm.key == key;
            // });
            // if(!dmItem)return;
            // var index = this.dms.indexOf(dmItem);

            // if(dmItem.quantity > 1){
            //     dmItem.quantity --;
            //     this.dms[index]=dmItem;
            // }else{
            this.dms = this.dms.filter((dm) => {
                return dm.key !== key;
            });
            //}
            // console.log("DMS");
            // console.log(this.dms);
            this.value = JSON.stringify(this.dms);
            this.field.value = this.value;
        },
        minusQuantity(dm){
            if (dm.quantity > 1) {
                var index = this.dms.indexOf(dm);
                this.dms[index].quantity = dm.quantity - 1;
                this.value = JSON.stringify(this.dms);
                //console.log(this.dms[index].quantity);
            }
        },
        plusQuantity(dm)
        {
            var index = this.dms.indexOf(dm);
           this.dms[index].quantity = dm.quantity + 1;
            //console.log(this.dms[index].quantity);
        },
        showModal(key)
        {
            this.showconfirmation = true;
            this.selecteditem = key;
        },

        handleConfirm(key) {
            if (key) {
            this.deleteItem(key);
            this.showconfirmation = false;
            this.selecteditem = null;
            }
        },
        /**
         * Close the modal.
         */
        handleClose() {
            this.showconfirmation = false;
        },
    }

}
</script>
