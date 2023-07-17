<script setup>
import Layout from "@/Shared/Layout.vue";
import NewQuestionModal from "@/Shared/NewQuestionModal.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const showNewQuestionModal = ref(false);
const createdQuestion = ref(null);
const newAnswers = ref([]);
const selectedAnswer = ref(null);
let answerId = 1;

function createQuestion() {
  showNewQuestionModal.value = true;
}

function destroyModal() {
  showNewQuestionModal.value = false;
}

function addNewAnswer() {
  const newAnswer = {
    id: answerId++,
    answer: '',
    correct_answer: 0
  }
  newAnswers.value.push(newAnswer)
}

// Function handle ketika checked di rubah
function handleRadioRoggle(id) {
  selectedAnswer.value = id;
  newAnswers.value.forEach(answer => {
    if (answer.id === id) {
      answer.correct_answer = 1
    } else {
      answer.correct_answer = 0
    }
  })
}

// Cek apakah answer tidak sama dengan kosong
// function validateAnswers() {
//   for (const answer of newAnswers.value) {
//     if (answer.answer.trim() === '') {
//       return false;
//     }else if(answer.correct_answer !== 1){
//       return false
//     }
//   }
//   return true;
// }

function validateAnswers() {
  let hasCorrectAnswer = false; // Inisialisasi variabel hasCorrectAnswer dengan nilai false

  for (const answer of newAnswers.value) {
    if (answer.answer.trim() === '') {
      return false;
    } else if (answer.correct_answer === 1) {
      hasCorrectAnswer = true; // Jika ada yang memiliki correct_answer === 1, set variabel hasCorrectAnswer menjadi true
    }
  }

  // Setelah looping selesai, periksa nilai hasCorrectAnswer
  if (hasCorrectAnswer) {
    return true; // Jika ada yang memiliki correct_answer === 1, return true
  } else {
    return false; // Jika tidak ada yang memiliki correct_answer === 1, return false
  }
}


// Cek apakah answer sudah diisi apa belum
function answerCount() {
  if (newAnswers.length < 4) {
    alert('Four answer required to submit')
  } else if (newAnswers.length === 4) {
    return true;
  }
  return false;
}

// Submit question
function submitQuestion() {
  if (!createdQuestion.value) {
    alert('Question cannot ve empty');
    return false;
  }

  if (!validateAnswers() && !answerCount()) {
    alert('Fill all inputs before submitting');
    return false;
  }

  router.post('/questions', {
    question: createdQuestion.value,
    answers: newAnswers.value
  })
}
</script>

<template>
  <Layout>
    <button @click="createQuestion" class="btn btn-sm btn-success">Create Question</button>

    <!-- Table -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Mark</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Julia</td>
        </tr>
      </tbody>
    </table>
    <!-- Table End -->

    <!-- Teleport atau modal -->
    <Teleport to="body">
      <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
        <template #header>
          <h5>Add New Question </h5>
        </template>
        <template #body>
          <form>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Question</label>
              <input v-model="createdQuestion" type="text" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp">
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Answer</th>
                  <th scope="col">Correct ?</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(answer, index) in newAnswers">
                  <th scope="row">{{ answer.id }}</th>
                  <td>
                    <input v-model="answer.answer" type="text" class="form-control" id="exampleInputEmail1"
                      aria-describedby="emailHelp">
                  </td>
                  <td>
                    <input :checked="answer.correct_answer === 1" class="form-check-input" :value="answer.id"
                      @change="handleRadioRoggle(answer.id)" type="radio">
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </template>
        <template #footer>
          <span @click="addNewAnswer" v-if="newAnswers.length < 4" style="cursor: pointer;">
            <h3>+</h3>
          </span>
          <button @click="destroyModal" class="btn btn-sm btn-danger">Close</button>
          <button @click="submitQuestion" v-if="newAnswers.length > 3" class="btn btn-sm btn-success">Submit</button>
        </template>
      </NewQuestionModal>
    </Teleport>
    <!-- Teleport atau modal -->

  </Layout>
</template>
