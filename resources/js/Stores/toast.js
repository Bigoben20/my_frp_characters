import { reactive } from "vue";

export default reactive({
    items: [],
    add(toast) {
        console.log(toast);
        this.items.unshift({
            key: Symbol(), //Bunu ekledik çünkü toaster sırayla gözükebilmesi için ona özel bir key tanımlamamız gerekiyor
            ...toast
        });
    },
    remove(index) {
        this.items.splice(index,1);
    }
})