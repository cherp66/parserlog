
<template>
 <div style="text-align:right" v-if="auth">
  Привет, {{ name }}! 
     <button type="submit" v-on:click="logout">Выход</button>
 </div>     
 <div style="text-align:right" v-else>
 <form v-on:submit.prevent="login">
     <input required v-model="username" type="text" placeholder="Логин"/>
     <input required v-model="password" type="password" placeholder="Пароль"/>
     <button type="submit">Войти</button>
 </form>     
     <div class="error">
        {{ error }}
     </div>
 </div>          
     <hr/>
</template>
