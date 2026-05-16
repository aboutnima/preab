<script setup lang="ts">
import {
    ArrowRight01Icon,
    ArrowUpDownIcon,
    DashboardSquare01Icon,
    Layers01Icon,
    Logout03Icon,
    PencilEdit01Icon,
    UserGroupIcon,
} from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
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
import type { NavItemProps, SharedPageProps } from '@/types';
import LogoutController from '@/wayfinder/actions/App/Http/Controllers/Company/Authentication/LogoutController';
import DashboardController from '@/wayfinder/actions/App/Http/Controllers/Company/DashboardController';
import EmployeeController from '@/wayfinder/actions/App/Http/Controllers/Company/Employees/EmployeeController';
import ProfileController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/ProfileController';

const page = usePage<SharedPageProps>();

const company = computed(() => page.props.auth);
const breadcrumbs = computed(() => page.props.breadcrumbs ?? []);

const props = defineProps<{
    title?: string;
    description?: string;
}>();

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
        icon: DashboardSquare01Icon,
    },
    {
        label: 'Employees',
        href: EmployeeController.index().url,
        icon: UserGroupIcon,
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
        <aside
            class="flex w-64 shrink-0 flex-col border-r border-border bg-sidebar"
        >
            <div
                class="flex h-14 items-center gap-2.5 border-b border-sidebar-border px-5"
            >
                <div
                    class="flex size-7 items-center justify-center rounded-md bg-foreground"
                >
                    <HugeiconsIcon
                        :icon="Layers01Icon"
                        :size="14"
                        class="text-background"
                        :stroke-width="2"
                    />
                </div>
                <span
                    class="text-sm font-semibold tracking-tight text-sidebar-foreground"
                    >Preab</span
                >
            </div>
            <nav class="flex-1 overflow-y-auto p-5">
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
            <div
                class="flex h-14 items-center border-t border-sidebar-border px-5"
            >
                <DropdownMenu>
                    <DropdownMenuTrigger
                        class="flex w-full items-center gap-2.5 rounded-md text-sm transition-colors hover:bg-sidebar-accent/60 focus:outline-none"
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
                        <HugeiconsIcon
                            :icon="ArrowUpDownIcon"
                            :size="14"
                            class="shrink-0 text-sidebar-foreground/40"
                            :stroke-width="2"
                        />
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
                            <HugeiconsIcon
                                :icon="PencilEdit01Icon"
                                :size="16"
                                class="mr-2"
                                :stroke-width="1.8"
                            />
                            Account settings
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem
                            class="cursor-pointer text-destructive focus:text-destructive"
                            @click="logout"
                        >
                            <HugeiconsIcon
                                :icon="Logout03Icon"
                                :size="16"
                                class="mr-2"
                                :stroke-width="1.8"
                            />
                            Sign out
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </aside>
        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
            <header
                class="flex h-14 shrink-0 items-center border-b border-border bg-background px-6"
            >
                <nav class="flex items-center gap-1.5 text-sm">
                    <template
                        v-for="(crumb, index) in breadcrumbs"
                        :key="index"
                    >
                        <HugeiconsIcon
                            v-if="index > 0"
                            :icon="ArrowRight01Icon"
                            :size="14"
                            class="shrink-0 text-border"
                            :stroke-width="2"
                        />

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
            <main class="flex-1 overflow-y-auto bg-background">
                <!-- Page header bar — shown when the page passes a title prop -->
                <div
                    v-show="props.title"
                    class="flex h-20 items-center border-b border-sidebar-border bg-gray-50 px-6 dark:bg-sidebar/50"
                >
                    <div class="flex flex-1 items-center justify-between">
                        <header class="flex flex-col gap-0.5">
                            <h3 class="text-base font-medium text-foreground">
                                {{ props.title }}
                            </h3>
                            <p
                                v-if="props.description"
                                class="text-sm text-muted-foreground"
                            >
                                {{ props.description }}
                            </p>
                        </header>
                        <!-- Teleport target for page-level action buttons -->
                        <div id="company-page-actions" class="flex items-center gap-4" />
                    </div>
                </div>
                <!-- Page content -->
                <div class="p-6 h-full">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
