<template>
    <div class="container">
        <div v-if="!commentsLoaded" class="text-center">
            <div class="w-5 h-5 border-2 border-teal-600 rounded-full loader"></div>
        </div>

        <div v-if="comments.length && commentsLoaded" class="pb-4">
            <div v-for="comment in comments" v-bind:key="comment.id">
                <div class="flex justify-between mb-1 pt-4 pb-1">
                    <p class="text-grey-darkest font-medium leading-normal text-base">{{ comment.details }}</p>
                    <button v-if="comment.meta.permissions.delete"
                            class="text-red hover:bg-red-300 hover:text-red
                            py-2 px-4 rounded tracking-wide mb-2 md:mb-0
                            md:ml-auto" @click="deleteComment(comment.id)">Delete
                    </button>
                </div>
                <div class="text-grey leading-normal text-sm">
                    <p>{{ get(comment, 'user.name', '') }} <span class="mx-1 text-xs">&bull;</span> {{
                            comment.created_at |
                                formatDateTime
                        }}</p>
                </div>
            </div>
        </div>
        <div class="py-4">
            <span
                v-if="!comments.length && commentsLoaded && !showCommentTextField">No comment yet for this requirement</span>
        </div>
        <button class="btn btn-secondary" v-show="!showCommentTextField" @click="showCommentTextField = true">
            Add comment
        </button>
        <div v-if="showCommentTextField">
            <div class="text-right">
                <button
                    @click="showCommentTextField = !showCommentTextField"
                    class="px-1 py-2 bg-white hover:bg-gray-300">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>

            </div>

            <textarea v-model="comment"
                      placeholder="Add comment"
                      class="primary-text-area">
            </textarea>

            <div class="text-right">
                <button class="btn btn-secondary" @click="postComment">Post</button>
            </div>
        </div>
    </div>
</template>
<script>
import requirementCommentRepository from "../../../repositories/requirementCommentRepository";
import commentRepository from "../../../repositories/comment/commentRepository";
import testCaseCommentRepository from "../../../repositories/testCase/comment/testCaseCommentRepository";

export default {
    name: 'comment-list',
    props: {
        requirement: Object,
        // determine which repository to retrieve the comments
        repositoryType: {
            type: String,
            default: 'requirement'
        },
        testCase: Object
    },
    data: () => ({
        comment: "",
        comments: [],
        commentsLoaded: false,
        showCommentTextField: false,
        repository: null,
        params: {}
    }),
    watch: {
        requirement() {
            this.commentsLoaded = false;
            this.showCommentTextField = false;

            if (this.requirement.id !== null) {
                this.fetchComments();
            }
        }
    },
    created() {
        this.fetchComments();
    },
    methods: {
        async postComment() {
            try {
                await this.repository.store(this.params.id, {details: this.comment});
                this.comment = "";
                this.showCommentTextField = false;
                await this.fetchComments();
            } catch (e) {
                console.log(e);
            }
        },
        async deleteComment(id) {
            try {
                await commentRepository.delete(id);
                this.comment = "";
                await this.fetchComments();
            } catch (e) {
                console.log(e);
            }
        },
        async fetchComments() {

            if (this.repositoryType === 'requirement') {
                this.repository = requirementCommentRepository;
                this.params = this.requirement;
            } else if (this.repositoryType === 'test-case') {
                this.repository = testCaseCommentRepository;
                this.params = this.testCase;
            }
            const response = await this.repository.all(this.params.id);
            this.comments = response.data.data;
            this.commentsLoaded = true;
        },
        get(data, parameters, defaultValue) {
            return _.get(data, parameters, defaultValue);
        }
    }

}
</script>

<style>

@keyframes loader-rotate {
    0% {
        transform: rotate(0);
    }
    100% {
        transform: rotate(360deg);
    }
}

.loader {
    border-right-color: transparent;
    animation: loader-rotate 1s linear infinite;
}

</style>


