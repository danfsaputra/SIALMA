<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useLayout } from "@/primevue/layout/composables/layout";
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
import Button from "primevue/button";
import useAuth from "@/composables/auth";
import Avatar from "primevue/avatar";

const { layoutConfig, onMenuToggle } = useLayout();
const { user, attempt } = useAuth();

const outsideClickListener = ref(null);
const topbarMenuActive = ref(false);

onMounted(async () => {
  bindOutsideClickListener();
  await attempt();
});

onBeforeUnmount(() => {
  unbindOutsideClickListener();
});

const logoUrl = computed(() => {
  return `layout/images/${
    layoutConfig.darkTheme.value ? "Logo-Kabupaten-Bojonegoro" : "Logo-Kabupaten-Bojonegoro"
  }.png`;
});

const onTopBarMenuButton = () => {
  topbarMenuActive.value = !topbarMenuActive.value;
};

const topbarMenuClasses = computed(() => {
  return {
    "layout-topbar-menu-mobile-active": topbarMenuActive.value,
  };
});

const bindOutsideClickListener = () => {
  if (!outsideClickListener.value) {
    outsideClickListener.value = (event) => {
      if (isOutsideClicked(event)) {
        topbarMenuActive.value = false;
      }
    };
    document.addEventListener("click", outsideClickListener.value);
  }
};

const unbindOutsideClickListener = () => {
  if (outsideClickListener.value) {
    document.removeEventListener("click", outsideClickListener);
    outsideClickListener.value = null;
  }
};

const isOutsideClicked = (event) => {
  if (!topbarMenuActive.value) return;

  const sidebarEl = document.querySelector(".layout-topbar-menu");
  const topbarEl = document.querySelector(".layout-topbar-menu-button");

  return !(
    sidebarEl.isSameNode(event.target) ||
    sidebarEl.contains(event.target) ||
    topbarEl.isSameNode(event.target) ||
    topbarEl.contains(event.target)
  );
};
</script>

<template>
  <div class="layout-topbar">
    <NavLink
      href="/dashboard"
      class="layout-topbar-logo"
    >
      <img
        :src="logoUrl"
        alt="logo"
      />
      <span>
        SiAlma
        <span class="text-blue-600 pi pi-verified"></span>
      </span>
    </NavLink>

    <button
      class="p-link layout-menu-button layout-topbar-button"
      @click="onMenuToggle()"
    >
      <i class="pi pi-bars"></i>
    </button>

    <button
      class="p-link layout-topbar-menu-button layout-topbar-button"
      @click="onTopBarMenuButton()"
    >
      <i class="pi pi-ellipsis-v"></i>
    </button>

    <div
      class="layout-topbar-menu"
      :class="topbarMenuClasses"
    >
      <div class="items-center justify-between me-4 grow lg:flex">
        <ul>
          <li>
            <Avatar
              icon="pi pi-user"
              style="background-color: #dee9fc; color: #1a2551"
              shape="circle"
            />
            {{ user?.name ?? "" }}
          </li>
        </ul>
      </div>

      <Link
        :href="route('logout')"
        method="POST"
        as="logoutApp"
      >
        <Button
          label="Logout"
          icon="pi pi-power-off"
          severity="danger"
          class="px-3 py-2"
          outlined
        />
      </Link>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>
