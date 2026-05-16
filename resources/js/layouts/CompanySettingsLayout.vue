<script setup lang="ts">
import {
    Image01Icon,
    LockIcon,
    Mail01Icon,
    UserIcon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
import { router, usePage } from '@inertiajs/vue3';
import type { NavItemProps, SharedPageProps } from '@/types';
import EmailController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/EmailController';
import LogoController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/LogoController';
import PasswordController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/PasswordController';
import ProfileController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/ProfileController';

const page = usePage<SharedPageProps>();

const settingsNav: NavItemProps[] = [
    { label: 'Profile', href: ProfileController.index().url, icon: UserIcon },
    { label: 'Logo', href: LogoController.index().url, icon: Image01Icon },
    {
        label: 'Email Address',
        href: EmailController.index().url,
        icon: Mail01Icon,
    },
    { label: 'Password', href: PasswordController.index().url, icon: LockIcon },
];

function isActive(href: string): boolean {
    return page.url === href;
}
</script>

<template>
    <div class="flex min-h-full -m-6">
        <aside class="flex w-56 shrink-0 flex-col border-r border-border">
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
                            <HugeiconsIcon
                                :icon="item.icon"
                                :size="16"
                                class="shrink-0"
                                :stroke-width="1.8"
                            />
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="min-w-0 flex-1 p-6">
            <slot />
        </div>
    </div>
</template>
