<script>

</script>

<template>
<div>
    <div class="header mb-3">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <router-link :to="{name: 'zoho.form.index'}" class="navbar-brand">ZohoForm</router-link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">

                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <slot></slot>
</div>
</template>

<style scoped>

</style>
