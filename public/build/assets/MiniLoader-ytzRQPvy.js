import{k as u,y as l,o as s,f as n,t as c,n as f,g,b as i}from"./app-kOMhi58c.js";import{_ as m}from"./_plugin-vue_export-helper-x3n3nnut.js";const p=["value"],y={key:1,class:"px-3 py-2 transition-all duration-100 border border-gray-300 rounded-md shadow-sm min-h-60 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"},V={__name:"TextAreaInput",props:{modelValue:{type:String,required:!0},auth:{type:Boolean,default:!0}},emits:["update:modelValue"],setup(e,{expose:r}){const o=u(null);return l(()=>{o.value.hasAttribute("autofocus")&&o.value.focus()}),r({focus:()=>o.value.focus()}),(a,t)=>e.auth?(s(),n("textarea",{key:0,class:"transition-all duration-100 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600",value:e.modelValue,onInput:t[0]||(t[0]=d=>a.$emit("update:modelValue",d.target.value)),ref_key:"input",ref:o},null,40,p)):(s(),n("div",y,c(e.modelValue),1))}},_={props:{show:{type:Boolean,default:!1},color:{type:String,default:"primary"},radius:{type:String,default:"5"}},setup(e){let r="animate-spin ";return r=r+"w-"+e.radius+" h-"+e.radius+" text-"+e.color,{baseClass:r}}},k=i("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"},null,-1),h=i("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"},null,-1),b=[k,h];function x(e,r,o,a,t,d){return o.show?(s(),n("svg",{key:0,class:f(a.baseClass),xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},b,2)):g("",!0)}const C=m(_,[["render",x]]);export{C as M,V as _};
