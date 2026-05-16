<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Separator } from '@/components/ui/separator';
import type { NavItemProps, SharedPageProps } from '@/types';
import EmailController from '@/actions/App/Http/Controllers/Company/Settings/EmailController';
import LogoController from '@/actions/App/Http/Controllers/Company/Settings/LogoController';
import PasswordController from '@/actions/App/Http/Controllers/Company/Settings/PasswordController';
import ProfileController from '@/actions/App/Http/Controllers/Company/Settings/ProfileController';

const page = usePage<SharedPageProps>();
const company = computed(() => page.props.auth);

const settingsNav: NavItemProps[] = [
    { label: 'Profile', href: ProfileController.index().url, icon: 'user' },
    { label: 'Logo', href: LogoController.index().url, icon: 'image' },
    {
        label: 'Email Address',
        href: EmailController.index().url,
        icon: 'email',
    },
    { label: 'Password', href: PasswordController.index().url, icon: 'lock' },
];

function isActive(href: string): boolean {
    return page.url === href;
}
</script>

<template>
    <div class="flex min-h-full">
        <aside class="flex w-56 shrink-0 flex-col border-r border-border">
            <div class="flex h-14 items-center border-b border-border px-5">
                <p
                    class="text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                >
                    Account Settings
                </p>
            </div>

            <nav class="flex-1 overflow-y-auto p-5">
                <ul class="space-y-0.5">
                    <li v-for="item in settingsNav" :key="item.href">
                        <a
                            :href="item.href"
                            class="flex items-center gap-2.5 rounded-md px-2.5 py-2 text-sm font-medium transition-colors"
                            :class="
                                isActive(item.href)
                                    ? 'bg-muted text-foreground'
                                    : 'text-muted-foreground hover:bg-muted/60 hover:text-foreground'
                            "
                            @click.prevent="router.visit(item.href)"
                        >
                            <svg
                                v-if="item.icon === 'user'"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="size-4 shrink-0"
                            >
                                <path
                                    d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <svg
                                v-else-if="item.icon === 'image'"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="size-4 shrink-0"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="2"
                                />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <svg
                                v-else-if="item.icon === 'email'"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="size-4 shrink-0"
                            >
                                <rect
                                    x="2"
                                    y="4"
                                    width="20"
                                    height="16"
                                    rx="2"
                                />
                                <path
                                    d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"
                                />
                            </svg>
                            <svg
                                v-else-if="item.icon === 'lock'"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="size-4 shrink-0"
                            >
                                <rect
                                    x="3"
                                    y="11"
                                    width="18"
                                    height="11"
                                    rx="2"
                                    ry="2"
                                />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="min-w-0 flex-1 px-8 py-6">
            <slot />
        </div>
    </div>
</template>
