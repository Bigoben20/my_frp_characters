import{I as x,A as h,B as p,h as b,o as g,c as k,a as n,w as i,i as r,s as c,b as t,x as d,e as u,n as B,r as C,g as E,J as M}from"./app-yB43UmE3.js";const N=t("div",{class:"absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"},null,-1),S=[N],W={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(e,{emit:y}){const s=e,f=y;x(()=>s.show,()=>{s.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const o=()=>{s.closeable&&f("close")},m=l=>{l.key==="Escape"&&s.show&&o()};h(()=>document.addEventListener("keydown",m)),p(()=>{document.removeEventListener("keydown",m),document.body.style.overflow=null});const v=b(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[s.maxWidth]);return(l,a)=>(g(),k(M,{to:"body"},[n(d,{"leave-active-class":"duration-200"},{default:i(()=>[r(t("div",{class:"fixed inset-0 z-50 px-4 py-6 overflow-y-auto sm:px-0","scroll-region":"",onClick:a[1]||(a[1]=u(w=>o(),["self"]))},[n(d,{"enter-active-class":"duration-300 ease-out","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"duration-200 ease-in","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:i(()=>[r(t("div",{class:"fixed inset-0 transition-all transform",onClick:a[0]||(a[0]=u(w=>o(),["self"]))},S,512),[[c,e.show]])]),_:1}),n(d,{"enter-active-class":"duration-300 ease-out","enter-from-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95","enter-to-class":"translate-y-0 opacity-100 sm:scale-100","leave-active-class":"duration-200 ease-in","leave-from-class":"translate-y-0 opacity-100 sm:scale-100","leave-to-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"},{default:i(()=>[r(t("div",{class:B(["mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:w-full sm:mx-auto",v.value])},[e.show?C(l.$slots,"default",{key:0}):E("",!0)],2),[[c,e.show]])]),_:3})],512),[[c,e.show]])]),_:3})]))}};export{W as _};
