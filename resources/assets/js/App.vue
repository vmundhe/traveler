<template>
    <div class="container">
        <div class="navbar navbar-toggleable-md fixed-top navbar-inverse bg-primary">
            <div class="navbar-brand">
                <router-link to="/">Traveler</router-link>
            </div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link to="/login">Sign In</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/register">Register</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/logout">Sign Out</router-link>
                </li>
            </ul>
        </div>
        <router-view></router-view>
    </div>
</template>
