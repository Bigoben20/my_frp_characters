import{Q as h,k as o,f as n,a as d,u as v,w as _,F as m,o as i,Z as f,b as e,i as p,p as y,s as b,t as x,q as k,g as w,B as D}from"./app-PCtwFQV_.js";import{a as S}from"./AuthenticatedLayout-JUJIfsTQ.js";import"./toast-Mzvg5Ksz.js";import{_ as B,M as C}from"./MiniLoader-dharhOR5.js";/* empty css                                                             */import"./ApplicationLogo-BcNsJOKV.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const M=e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},"DND GPT",-1),N={class:"py-4 sm:py-12"},T={class:"mx-auto max-w-7xl"},G={class:"p-4 sm:rounded-lg md:p-8 dark:bg-gray-800"},P=e("div",{class:"mb-4 header"}," Sohbet Başlat ",-1),V={class:"flex flex-col gap-4 pb-4"},j=e("div",{class:"-mb-3 text-xs text-red-500"}," * Tek mesajlık sohbet şeklinde çalışmaktadır ",-1),L={class:"flex flex-col items-stretch"},E=["disabled"],F=e("span",null," Gönder ",-1),I={class:"fa-regular fa-paper-plane"},$={key:0,class:"px-2 mt-4 border-t border-gray-400"},q={class:"flex justify-end w-full"},z={class:"flex flex-col items-end"},A=e("div",{class:"dark:text-gray-300"}," Siz: ",-1),Q={class:"max-w-4xl px-3 py-2 bg-stone-200 dark:bg-opacity-85 rounded-[0.75rem_0.75rem_0px_0.75rem]"},U=e("div",{class:"dark:text-gray-300"}," D&D GPT: ",-1),Z={class:"flex flex-col gap-4"},ee={__name:"GPTChat",setup(H){h();const s=o(""),r=o(""),c=o([]),a=o(!1),g=async()=>{r.value=s.value,s.value="",a.value=!0,await D.post("/send-dnd-gpt",{message:r.value,creativeness:.7}).then(t=>{console.log(t.data),c.value=t.data.data}).catch(t=>{console.error("API çağrısında hata oluştu:",t)}).finally(()=>{a.value=!1})};return(t,u)=>(i(),n(m,null,[d(v(f),{title:"DND Chat"}),d(S,null,{header:_(()=>[M]),default:_(()=>[e("div",N,[e("div",T,[e("div",G,[P,e("div",null,[e("div",V,[j,e("div",L,[p(e("textarea",{class:"generalInput",maxlength:"300","onUpdate:modelValue":u[0]||(u[0]=l=>s.value=l),placeholder:"Sorun nedir?"},null,512),[[y,s.value]]),d(B,{maxlength:"300",value:s.value.length},null,8,["value"])]),e("button",{type:"button",onClick:g,class:"flex items-center justify-center gap-1 px-4 py-2 text-indigo-700 bg-indigo-200 rounded hoverEffect",disabled:a.value},[F,p(e("i",I,null,512),[[b,!a.value]]),d(C,{show:a.value,radius:"4"},null,8,["show"])],8,E)]),c.value.length>0?(i(),n("div",$,[e("div",q,[e("div",z,[A,e("div",Q,x(r.value),1)])]),U,e("div",Z,[(i(!0),n(m,null,k(c.value,l=>(i(),n("div",{key:l.index,class:"max-w-4xl px-3 py-2 bg-indigo-100 dark:bg-indigo-200/90 rounded-[0.75rem_0.75rem_0.75rem_0px]"},x(l.message.content),1))),128))])])):w("",!0)])])])])]),_:1})],64))}};export{ee as default};