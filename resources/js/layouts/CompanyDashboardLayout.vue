<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Separator } from '@/components/ui/separator';
import type { NavItemProps, SharedPageProps } from '@/types';
import LogoutController from '@/wayfinder/actions/App/Http/Controllers/Company/Authentication/LogoutController';
import DashboardController from '@/wayfinder/actions/App/Http/Controllers/Company/DashboardController';
import ProfileController from '@/actions/App/Http/Controllers/Company/Settings/ProfileController';

const page = usePage<SharedPageProps>();

const company = computed(() => page.props.auth);
const breadcrumbs = computed(() => page.props.breadcrumbs ?? []);

const companyInitials = computed(() => {
    return (
        company.value?.name
            ?.split(' ')
            .slice(0, 2)
            .map((w) => w[0])
            .join('')
            .toUpperCase() ?? '??'
    );
});

const navItems: NavItemProps[] = [
    {
        label: 'Dashboard',
        href: DashboardController.index().url,
        icon: 'dashboard',
    },
    {
        label: 'Account Settings',
        href: ProfileController.index().url,
        icon: 'settings',
    },
];

function isActive(href: string): boolean {
    return page.url.startsWith(href);
}

function logout(): void {
    router.post(LogoutController.store().url);
}
</script>

<template>
    <div class="flex h-screen overflow-hidden bg-background">
        <!-- ─── Sidebar ─────────────────────────────────────── -->
        <aside
            class="flex w-64 shrink-0 flex-col border-r border-border bg-sidebar"
        >
            <!-- Logo -->
            <div
                class="flex h-14 items-center gap-2.5 border-b border-sidebar-border px-5"
            >
                <div
                    class="flex size-7 items-center justify-center rounded-md bg-foreground"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-3.5 text-background"
                    >
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <span
                    class="text-sm font-semibold tracking-tight text-sidebar-foreground"
                    >Preab</span
                >
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto px-3 py-4">
                <ul class="space-y-0.5">
                    <li v-for="item in navItems" :key="item.href">
                        <a
                            :href="item.href"
                            class="group flex items-center gap-2.5 rounded-md px-2.5 py-2 text-sm font-medium transition-colors"
                            :class="
                                isActive(item.href)
                                    ? 'bg-sidebar-accent text-sidebar-accent-foreground'
                                    : 'text-sidebar-foreground/70 hover:bg-sidebar-accent/60 hover:text-sidebar-foreground'
                            "
                            @click.prevent="router.visit(item.href)"
                        >
                            <template v-if="item.icon === 'dashboard'">
                                <svg
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
                                        width="7"
                                        height="7"
                                        rx="1"
                                    />
                                    <rect
                                        x="14"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    />
                                    <rect
                                        x="3"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    />
                                    <rect
                                        x="14"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1"
                                    />
                                </svg>
                            </template>
                            <template v-else-if="item.icon === 'settings'">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="size-4 shrink-0"
                                >
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                                </svg>
                            </template>
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Bottom: separator + company menu -->
            <div class="px-3 pb-4">
                <Separator class="mb-3 bg-sidebar-border" />

                <DropdownMenu>
                    <DropdownMenuTrigger
                        class="flex w-full items-center gap-2.5 rounded-md px-2.5 py-2 text-sm transition-colors hover:bg-sidebar-accent/60 focus:outline-none"
                    >
                        <Avatar class="size-7 shrink-0">
                            <AvatarFallback
                                class="bg-foreground text-[11px] font-semibold text-background"
                            >
                                {{ companyInitials }}
                            </AvatarFallback>
                        </Avatar>
                        <div class="min-w-0 flex-1 text-left">
                            <p
                                class="truncate text-xs font-medium text-sidebar-foreground"
                            >
                                {{ company?.name }}
                            </p>
                            <p
                                class="truncate text-[11px] text-sidebar-foreground/50"
                            >
                                {{ company?.email }}
                            </p>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="size-3.5 shrink-0 text-sidebar-foreground/40"
                        >
                            <path d="M8 9l4-4 4 4" />
                            <path d="M16 15l-4 4-4-4" />
                        </svg>
                    </DropdownMenuTrigger>

                    <DropdownMenuContent align="end" side="top" class="w-52">
                        <DropdownMenuLabel class="font-normal">
                            <div class="flex flex-col gap-0.5">
                                <span class="truncate text-xs font-semibold">{{
                                    company?.name
                                }}</span>
                                <span
                                    class="truncate text-[11px] text-muted-foreground"
                                    >{{ company?.email }}</span
                                >
                            </div>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem
                            class="cursor-pointer"
                            @click="router.visit(ProfileController.index().url)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="mr-2 size-4"
                            >
                                <path d="M12 20h9" />
                                <path
                                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"
                                />
                            </svg>
                            Account settings
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem
                            class="cursor-pointer text-destructive focus:text-destructive"
                            @click="logout"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="mr-2 size-4"
                            >
                                <path
                                    d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                                />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Sign out
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </aside>

        <!-- ─── Main column ────────────────────────────────── -->
        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
            <!-- Top navbar / breadcrumb bar -->
            <header
                class="flex h-14 shrink-0 items-center border-b border-border bg-background px-6"
            >
                <nav class="flex items-center gap-1.5 text-sm">
                    <template
                        v-for="(crumb, index) in breadcrumbs"
                        :key="index"
                    >
                        <svg
                            v-if="index > 0"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="size-3.5 shrink-0 text-border"
                        >
                            <polyline points="9 18 15 12 9 6" />
                        </svg>

                        <a
                            v-if="crumb.href && index < breadcrumbs.length - 1"
                            :href="crumb.href"
                            class="text-muted-foreground transition-colors hover:text-foreground"
                            @click.prevent="router.visit(crumb.href)"
                        >
                            {{ crumb.label }}
                        </a>
                        <span v-else class="font-medium text-foreground">
                            {{ crumb.label }}
                        </span>
                    </template>
                </nav>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-background">
                <slot />
            </main>
        </div>
    </div>
</template>
