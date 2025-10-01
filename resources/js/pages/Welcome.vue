<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <Head title="Welcome to TaskFox">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#0A2842] p-6 text-white lg:justify-center lg:p-8"
    >
        <header
            class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl"
        >
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-block rounded-sm border border-white/20 px-5 py-1.5 text-sm leading-normal text-white hover:border-white/40 transition-colors duration-200"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-white hover:border-white/20 transition-colors duration-200"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="register()"
                        class="inline-block rounded-sm border border-white/20 px-5 py-1.5 text-sm leading-normal text-white hover:border-white/40 transition-colors duration-200"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <main
                class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row"
            >
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white/10 backdrop-blur-sm p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(255,255,255,0.1)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 animate-fade-in-up"
                >
                    <div class="flex items-center gap-3 mb-4 animate-fade-in-up" style="animation-delay: 0.2s">
                        <AppLogoIcon class="w-8 h-8 text-[#FF6E00]" />
                        <h1 class="text-2xl font-bold text-white">TaskFox</h1>
                    </div>
                    <h2 class="mb-1 font-medium text-white text-xl">Organize Your Tasks, Boost Your Productivity</h2>
                    <p class="mb-2 text-white/80">
                        TaskFox helps you manage your tasks efficiently with smart categorization, 
                        <br />priority tracking, and deadline management.
                    </p>
                    <ul class="mb-4 flex flex-col lg:mb-6 space-y-3">
                        <li
                            class="relative flex items-center gap-4 py-2 animate-fade-in-up"
                            style="animation-delay: 0.4s"
                        >
                            <span
                                class="relative bg-white/10 py-1"
                            >
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-white/20 bg-white/5"
                                >
                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-[#FF6E00]"
                                    />
                                </span>
                            </span>
                            <span class="text-white/90">
                                Create and organize tasks with
                                <span class="ml-1 font-medium text-[#FF6E00]">smart categories</span>
                            </span>
                        </li>
                        <li
                            class="relative flex items-center gap-4 py-2 animate-fade-in-up"
                            style="animation-delay: 0.6s"
                        >
                            <span
                                class="relative bg-white/10 py-1"
                            >
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-white/20 bg-white/5"
                                >
                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-[#FF6E00]"
                                    />
                                </span>
                            </span>
                            <span class="text-white/90">
                                Track progress with
                                <span class="ml-1 font-medium text-[#FF6E00]">priority levels</span>
                            </span>
                        </li>
                        <li
                            class="relative flex items-center gap-4 py-2 animate-fade-in-up"
                            style="animation-delay: 0.8s"
                        >
                            <span
                                class="relative bg-white/10 py-1"
                            >
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-white/20 bg-white/5"
                                >
                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-[#FF6E00]"
                                    />
                                </span>
                            </span>
                            <span class="text-white/90">
                                Never miss deadlines with
                                <span class="ml-1 font-medium text-[#FF6E00]">due date tracking</span>
                            </span>
                        </li>
                    </ul>
                    <div class="flex gap-3 text-sm leading-normal animate-fade-in-up" style="animation-delay: 1s">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="dashboard()"
                            class="inline-block rounded-sm border border-[#FF6E00] bg-[#FF6E00] px-5 py-1.5 text-sm leading-normal text-white hover:bg-[#FF6E00]/90 hover:border-[#FF6E00]/90 transition-colors duration-200"
                        >
                            Go to Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="register()"
                                class="inline-block rounded-sm border border-[#FF6E00] bg-[#FF6E00] px-5 py-1.5 text-sm leading-normal text-white hover:bg-[#FF6E00]/90 hover:border-[#FF6E00]/90 transition-colors duration-200"
                            >
                                Get Started
                            </Link>
                        </template>
                    </div>
                </div>
                <div
                    class="relative -mb-px aspect-335/376 w-full shrink-0 overflow-hidden rounded-t-lg bg-gradient-to-br from-[#FF6E00]/20 to-[#FF6E00]/5 lg:mb-0 lg:-ml-px lg:aspect-auto lg:w-[438px] lg:rounded-t-none lg:rounded-r-lg"
                >
                    <!-- TaskFox Logo and Animation -->
                    <div class="flex flex-col items-center justify-center h-full p-8 animate-fade-in-up" style="animation-delay: 0.3s">
                        <div class="relative mb-8">
                            <AppLogoIcon class="w-24 h-24 text-[#FF6E00] animate-bounce" style="animation-duration: 2s; animation-iteration-count: infinite;" />
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-[#FF6E00] rounded-full animate-ping opacity-75"></div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-white mb-4 animate-fade-in-up" style="animation-delay: 0.6s">
                            Welcome to TaskFox
                        </h3>
                        
                        <div class="flex flex-col items-center space-y-4 animate-fade-in-up" style="animation-delay: 0.9s">
                            <div class="flex items-center space-x-2 text-white/80">
                                <div class="w-2 h-2 bg-[#FF6E00] rounded-full animate-pulse"></div>
                                <span class="text-sm">Smart Task Management</span>
                            </div>
                            <div class="flex items-center space-x-2 text-white/80">
                                <div class="w-2 h-2 bg-[#FF6E00] rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                                <span class="text-sm">Priority Tracking</span>
                            </div>
                            <div class="flex items-center space-x-2 text-white/80">
                                <div class="w-2 h-2 bg-[#FF6E00] rounded-full animate-pulse" style="animation-delay: 1s"></div>
                                <span class="text-sm">Deadline Management</span>
                            </div>
                        </div>
                    </div>
                    
                    <div
                        class="absolute inset-0 rounded-t-lg shadow-[inset_0px_0px_0px_1px_rgba(255,255,255,0.1)] lg:overflow-hidden lg:rounded-t-none lg:rounded-r-lg"
                    />
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>


