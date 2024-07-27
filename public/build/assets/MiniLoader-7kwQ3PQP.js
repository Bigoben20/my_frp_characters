import{k as u,A as c,o as n,f as l,b as r,t as d,d as m,n as f,g as p}from"./app-yB43UmE3.js";import{_}from"./_plugin-vue_export-helper-x3n3nnut.js";const g=["disabled","aria-readonly","value"],B={__name:"TextAreaInput",props:{modelValue:{type:String,required:!1},auth:{type:Boolean,default:!0}},emits:["update:modelValue"],setup(e,{expose:t}){const a=u(null);return c(()=>{}),t({focus:()=>a.value.focus()}),(s,o)=>(n(),l("textarea",{disabled:!e.auth,"aria-readonly":!e.auth,class:"transition-all duration-100 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600",value:e.modelValue,onInput:o[0]||(o[0]=i=>s.$emit("update:modelValue",i.target.value)),ref_key:"input",ref:a},null,40,g))}},h={class:"flex items-center justify-end w-full text-sm dark:text-white"},x={class:"text-lime-600 dark:text-lime-300"},y={class:""},S={__name:"TextCounter",props:{value:{type:String,required:!0},maxlength:{type:String,required:!0}},setup(e){return(t,a)=>(n(),l("div",h,[r("span",x,d(e.value),1),m("  /  "),r("span",y,d(e.maxlength),1)]))}},k={props:{show:{type:Boolean,default:!1},color:{type:String,default:"primary"},radius:{type:String,default:"5"}},setup(e){let t="animate-spin ";return t=t+"w-"+e.radius+" h-"+e.radius+" text-"+e.color,{baseClass:t}}},w=r("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"},null,-1),b=r("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"},null,-1),v=[w,b];function $(e,t,a,s,o,i){return a.show?(n(),l("svg",{key:0,class:f(s.baseClass),xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},v,2)):p("",!0)}const M=_(k,[["render",$]]);export{M,B as _,S as a};
