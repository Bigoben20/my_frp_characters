import{T as d,c as u,w as l,o as i,a as t,u as s,Z as c,f,t as p,g as _,b as a,d as w,n as g,e as y}from"./app-XzJrbN61.js";import{_ as x}from"./GuestLayout-meE6cXdl.js";import{_ as k,a as b}from"./InputLabel-khXQJdMi.js";import{P as V}from"./PrimaryButton-P70gnld8.js";import{_ as h}from"./TextInput-4EKI5Tar.js";import"./ApplicationLogo--MBRgEhg.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const v=a("div",{class:"mb-4 text-sm text-gray-600 dark:text-gray-400"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),B={key:0,class:"mb-4 font-medium text-sm text-green-600 dark:text-green-400"},N={class:"flex items-center justify-end mt-4"},q={__name:"ForgotPassword",props:{status:{type:String}},setup(o){const e=d({email:""}),m=()=>{e.post(route("password.email"))};return(P,r)=>(i(),u(x,null,{default:l(()=>[t(s(c),{title:"Forgot Password"}),v,o.status?(i(),f("div",B,p(o.status),1)):_("",!0),a("form",{onSubmit:y(m,["prevent"])},[a("div",null,[t(k,{for:"email",value:"Email"}),t(h,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":r[0]||(r[0]=n=>s(e).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),t(b,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),a("div",N,[t(V,{class:g({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:l(()=>[w(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{q as default};
