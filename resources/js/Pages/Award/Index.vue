<template>
  <Head title="User" />
  <form @submit.prevent="form.post('/admin/user')">
    <div class="flex flex-row justify-between items-center h-32">
      <h3 class="text-red-500 font-bold text-lg">افزودن جوایز و افتخارات</h3>
      <div class="flex flex-row gap-5">
        <Link
          class="px-3 py-3 rounded-2xl bg-neutral-100 text-sm text-slate-600 cursor-pointer hover:scale-95 delay-100 hover:ring-red-600 hover:ring-offset-stone-600 hover:shadow-lg hover:shadow-red-100 hover:ring-4 duration-200 ease-in"
          as="div"
          href="#"
          >مشاهده لیست
        </Link>
        <Link
          class="px-3 py-3 rounded-2xl bg-neutral-100 text-sm text-slate-600 cursor-pointer hover:scale-95 delay-100 hover:ring-red-600 hover:ring-offset-stone-600 hover:shadow-lg hover:shadow-red-100 hover:ring-4 duration-200 ease-in"
          as="div"
          href="#"
          >افزودن مجموعه جدید
        </Link>
      </div>
    </div>
    <div class="py-12">
      <nav class="flex border-b border-gray-100 text-sm font-medium">
        <a
          href=""
          class="-mb-px border-b border-b-4 border-red-500 font-bold border-current p-4 text-black"
        >
          مشخصات
        </a>
        <a href="" class="-mb-px font-base border-current p-4 text-black"> تصاویر </a>
      </nav>
    </div>
    <div
      v-if="$page.props.flash.error"
      class="text-red-500 border-red-500 bg-red-50 border p-5 rounded-lg mb-10 duration-1000"
    >
      {{ $page.props.flash.error }}
    </div>
    <div
      v-if="$page.props.flash.success"
      class="text-emerald-500 border-green-500 bg-emerald-50 border p-5 rounded-lg mb-10 duration-1000"
    >
      {{ $page.props.flash.success }}
    </div>

    <div class="flex flex-col lg:flex-row jutfiy-start items-start gap-4">
      <div class="w-full lg:w-3/4 flex flex-col gap-4">
        <div class="p-5 rounded-xl bg-slate-100 grid">
          <h1 class="font-black text-neutral-600">مشخصات</h1>
          <div class="grid grid-cols-1 gap-8 m-5 mt-10">
            <div class="flex flex-col gap-4">
              <label class="text-sm text-slate-600">نام</label>
              <input
                class="bg-neutral-200/50 rounded-xl outline-0 w-full p-3 focus:shadow-inner focus:shadow-slate-200 text-slate-500"
                :class="{ 'border-red-500 border bg-red-50': errors.title }"
                v-model="form.title"
              />
              <div class="text-xs text-red-600" v-if="errors.title">
                {{ errors.title }}
              </div>
            </div>
            <div class="flex flex-col gap-4">
              <label class="text-sm text-slate-600">توضیحات</label>
              <textarea
                rows="6"
                class="bg-neutral-200/50 rounded-xl outline-0 w-full p-3 focus:shadow-inner focus:shadow-slate-200 text-slate-500"
                :class="{ 'border-red-500 border bg-red-50': errors.description }"
                v-model="form.description"
              ></textarea>
              <div class="text-xs text-red-600" v-if="errors.description">
                {{ errors.description }}
              </div>
            </div>
            <div class="flex flex-col gap-4">
              <label class="text-sm text-slate-600">نوع</label>
              <select
                v-model="form.type"
                :class="{ 'border-red-500 border bg-red-50': errors.type }"
                class="max-w-sm bg-neutral-200/50 rounded-xl outline-0 w-full p-2 pe-10 focus:shadow-inner focus:shadow-slate-200 text-slate-500"
              >
                <option selected>نوع جایزه را انتخاب کنید</option>
                <option value="award">جایزه</option>
                <option value="competition">مسابقه</option>
              </select>
              <div class="text-xs text-red-600" v-if="errors.type">{{ errors.type }}</div>
            </div>
          </div>
        </div>
        <div class="p-5 rounded-xl bg-slate-100 grid">
          <h1 class="font-black text-neutral-600">تصاویر</h1>
          <div class="flex flex-row justify-start items-start gap-4 mt-5">
            <Upload v-model="image_id"></Upload>
            <Upload v-model="cover_id"></Upload>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-1/4 p-5 rounded-xl bg-slate-100">
        <h3>ذخیره</h3>
        <div class="flex flex-col gap-4">
          <Status v-model="form.status" />
          {{ form.status }}
        </div>
        <div>
          <button
            type="submit"
            :disabled="form.processing || !form.isDirty"
            class="disabled:bg-slate-400 w-full space-x-5 py-2 text-center rounded-full bg-teal-500 text-white mt-10"
          >
            ذخیره
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Status from "@/Components/Status.vue";
import Upload from "@/Components/Upload.vue";
export default {
  layout: AdminLayout,
};
</script>
<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { usePage, useForm } from "@inertiajs/inertia-vue3";
import { computed, defineProps } from "vue";
const props = defineProps({ errors: Object });
const user = computed(() => usePage().props.value.auth.user);
console.log(user.value);
const form = useForm({
  title: null,
  description: null,
  type: null,
  status: true,
  image_id: null,
  cover_id: null,
});
</script>
